## Zkteco Laravel Attendance library

This package easy to use functions to ZKTeco Device activities with **laravel** framework.

**Requires:** Laravel >= 10.0

**License:** MIT

### About

**Laravel** ZKLibrary is a PHP library for ZK Time and Attendance Devices. This library supports reading and writing data to attendance devices (fingerprint, facial recognition, or RFID) over UDP protocol. This library enables direct communication between a web server and an attendance device without the need for additional programs. This library's implementation takes the form

of class. So that you can construct an object and then use its functions.

The web server must be connected to the attendance device via a Local Area Network (LAN). The UDP port utilized for this transmission is 4370. You cannot update this port without first updating the attendance device's software. Just use it.

The data format is binary, string, and numeric. The length of the parameter.

## Installation

Begin by installing this package through Composer. Just run following command to terminal-

    composer require raysulkobir/zkteco-laravel

Once this operation completes, the final step is to add the service provider. Open config/app.php, and add a new item to
the providers array.

    'providers' => [

            // .........................
             ZktecoServiceProvider::class,

        ]

If you want to change Zkteco settings , you need to publish its config file(s). For that you need to set ip address in the terminal-

    php artisan vendor:publish

# Usages

##### Create a object of ZKTeco class.

        use Raysulkobir\ZktecoLaravel\Lib\ZKTeco;;

    //  1 s't parameter is string ip Device IP Address
    //  2 nd  parameter is integer port Default: 4370

        $zk = new ZKTeco('192.168.1.210');

    //  or you can use with port
    //    $zk = new ZKTeco('192.168.1.210', 8080);

    // Create database
    // php artisan migrate
    - Create table
       // finger_devices
       // employees
       // schedules
       // attendances
       // latetimes
       // leaves
       // overtimes
       // attendance_logs

       - Add schedules first.
       - Add employment

       - Get attendance
       // Current information Every guest receives this and a point request.
       // http://example-app.com/zkteco/get-attendance-log

       - Generate report
       // generate a report using current data
       // example-app.com/zkteco/get-attendanc

##### Call ZKTeco methods.

- Connect

      //   this return bool
           $zk->connect()

- Disconnect

       // this is return bool
       $zk->disconnect()

- Enable Device

       // this is return bool//mixed
       $zk->enableDevice()

- Disable Device

       // this is return bool//mixed
       $zk->disableDevice()

- Device Version

  // this return bool/mixed

      $zk->version();

- Device Restart

       // this is return bool//mixed
       $zk->restart()

- Device Serial Number

        //    get device serial number
       $zk->serialNumber()

- Device Name

        //    get device name
       $zk->deviceName()

- Device PIN Width

        //    get device pin width
       $zk->pinWidth()

- Device SSR

        //    get device ssr
       $zk->ssr()

- Device Platform

        //    get device platform
       $zk->platform()

- Get Attendance

       //    return array[]
       $zk->getAttendance()

- Clear Attendance

       //   return bool/mixed
       $zk->clearAttendance()

- Clear Admin

       //    remove all admin
       //    return bool|mixed
       $zk->clearAdmin()

- Clear User

       //    remove all users
       //    return bool|mixed
       $zk->clearUser()

- Get User

        //    get User
        //    this return array[]
        $zk->getUser()

- Delete User

        //    parameter integer $uid
        //    return bool|mixed
        $zk->deleteUser()

- Set/Add User

        //    1 s't parameter int $uid Unique ID (max 65535)
        //    2 nd parameter int|string $userid ID in DB (same like $uid, max length = 9, only numbers - depends device setting)
        //    3 rd parameter string $name (max length = 24)
        //    4 th parameter int|string $password (max length = 8, only numbers - depends device setting)
        //    5 th parameter int $role Default Util::LEVEL_USER
        //    return bool|mixed
        $zk->setUser()
