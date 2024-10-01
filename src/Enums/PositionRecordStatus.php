<?php

namespace Mdpbriar\ForemApiPhpClient\Enums;

enum PositionRecordStatus: string
{
    case Active = "Active";
    case Inactive = "Inactive";
    case Pending = "Pending";
}
