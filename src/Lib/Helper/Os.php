<?php

namespace Raysulkobir\ZktecoLaravel\Lib\Helper;

use Raysulkobir\ZktecoLaravel\Lib\ZKTeco;

class Os
{
    /**
     * @param ZKTeco $self
     * @return bool|mixed
     */
    static public function get(ZKTeco $self)
    {
        $self->_section = __METHOD__;

        $command = Util::CMD_DEVICE;
        $command_string = '~OS';

        return $self->_command($command, $command_string);
    }
}
