<?php

namespace Raysulkobir\ZktecoLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Raysulkobir\ZktecoLaravel\Lib\ZKTeco;
use Raysulkobir\ZktecoLaravel\Models\Leave;
use Raysulkobir\ZktecoLaravel\Models\Employee;
use Raysulkobir\ZktecoLaravel\Models\Attendance;
use Raysulkobir\ZktecoLaravel\Models\FingerDevices;
use Raysulkobir\ZktecoLaravel\Models\AttendanceLog;
use DateTime;
use Carbon\Carbon;

class CronJobManagementController extends Controller
{
    //* get attendanceLog
    public function getAttendanceLog()
    {
        $fingerDevices = FingerDevices::get();
        foreach ($fingerDevices as $device) {
            return $this->attendanceLogInsert($device->id, $device->ip, $device->tcp_port);
        }
    }
    //TODO Get Attendance Log helper function
    protected function attendanceLogInsert($id, $ip, $tcp_port)
    {
        $type = 1;
        try {
            $device = new ZKTeco($ip, $tcp_port);
            $device->connect();
            $getAllAttendanceData = $device->getAttendance();

            if ($type) {
                $currentDate = Carbon::today()->toDateString();
                $currentDate = '2024-03-20';
                //TODO Filter the data based on the current date
                $getAllAttendanceData = array_filter($getAllAttendanceData, function ($item) use ($currentDate) {
                    $itemDate = Carbon::parse($item['timestamp'])->toDateString();
                    return $itemDate === $currentDate;
                });

                $attendance = AttendanceLog::whereDate('timestamp', $currentDate)->where('device_id', $id)->orderBy('id', 'DESC')->first();
                if (isset($attendance) && !empty($attendance)) {
                    $currentDate = $attendance->timestamp;
                    $getAllAttendanceData = array_filter($getAllAttendanceData, function ($item) use ($currentDate) {
                        $itemDate = strtotime($item['timestamp']);
                        return $itemDate > strtotime($currentDate);
                    });
                }
            }

            //! Attendance Log insert
            foreach ($getAllAttendanceData as $attendance) {
                $attendanceLog = new AttendanceLog();
                $attendanceLog->emp_id = $attendance['id'];
                $attendanceLog->state = $attendance['state'];
                $attendanceLog->timestamp = $attendance['timestamp'];
                $attendanceLog->type = $attendance['type'];
                $attendanceLog->device_id = $id;
                $attendanceLog->save();
            }
            // return back()->with('create', 'Attendance Queue will run in a minute!');
        } catch (\Throwable $th) {
            return $th->getMessage();
            Log::error("Employee Add: " . $th->getMessage());
            return response("An error occurred. Please try again later.", 500);
        }
    }

    //* get Attendance
    public function getAttendance()
    {
        $attendanceLog = AttendanceLog::whereDate('timestamp', '=', Carbon::today()->toDateString())->get();
        $firstLastTimestamps = [];

        foreach ($attendanceLog as $attendance) {
            $emp_id = $attendance->emp_id;
            $state = $attendance->state;
            $type = $attendance->type;
            $device_id = $attendance->device_id;
            $timestamp = $attendance->timestamp;

            if (!isset($firstLastTimestamps[$emp_id])) {
                $firstLastTimestamps[$emp_id] = ['emp_id' => $emp_id, 'state' => $state, 'type' => $type, 'device_id' => $device_id, 'first' => $timestamp, 'last' => $timestamp];
            } else {
                if ($timestamp < $firstLastTimestamps[$emp_id]['first']) {
                    $firstLastTimestamps[$emp_id]['first'] = $timestamp;
                }

                if ($timestamp > $firstLastTimestamps[$emp_id]['last']) {
                    $firstLastTimestamps[$emp_id]['last'] = $timestamp;
                }
            }
        }
        return $this->attendanceInsert($firstLastTimestamps);
    }
    // TODO attendanceInsert helper function
    public function attendanceInsert($firstLastTimestamps)
    {
        foreach ($firstLastTimestamps as $attendance) {
            if ($employee = Employee::where('emp_id', $attendance['emp_id'])->first()) {
                $attendanceCheck = Attendance::whereAttendance_date(date('Y-m-d', strtotime($attendance['first'])))
                    ->whereEmp_id($attendance['emp_id'])
                    ->first();

                if (!$attendanceCheck) {
                    $att_table = new Attendance();
                    $att_table->uid = $attendance['emp_id'];
                    $att_table->emp_id = $attendance['emp_id'];
                    $att_table->state = $attendance['state'];
                    $att_table->attendance_time = date('H:i:s', strtotime($attendance['first']));
                    $att_table->check_in = date('H:i:s', strtotime($attendance['first']));
                    $att_table->check_out = strtotime($attendance['first']) != strtotime($attendance['last']) ? date('H:i:s', strtotime($attendance['last'])) : "00:00";
                    $att_table->attendance_date = date('Y-m-d', strtotime($attendance['first']));
                    $att_table->type = $attendance['type'];
                    $att_table->device_id = $attendance['device_id'];

                    if (!($employee->schedules->first()->time_in >= $att_table->attendance_time)) {
                        $att_table->status = 0;
                        $this->lateTimeDevice($attendance['last'], $employee);
                    }
                    $att_table->save();
                } else {
                    $att_table = Attendance::find($attendanceCheck->id);
                    $att_table->check_out = strtotime($attendance['first']) != strtotime($attendance['last']) ? date('H:i:s', strtotime($attendance['last'])) : "00:00";
                    $att_table->update();
                }
            }
        }
    }
    // TODO getAttendance helper function
    protected function lateTimeDevice($att_dateTime, $employee)
    {
        $attendance_time = new DateTime($att_dateTime);
        $checkin = new DateTime($employee->schedules->first()->time_in);
        $difference = $checkin->diff($attendance_time)->format('%H:%I:%S');

        $latetime = new Latetime();
        $latetime->emp_id = $employee->id;
        $latetime->duration = $difference;
        $latetime->latetime_date = date('Y-m-d', strtotime($att_dateTime));
        $latetime->save();
    }
}
