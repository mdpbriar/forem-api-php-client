<?php

namespace Mdpbriar\ForemApiPhpClient\Enums;

enum BasePayInterval: string
{
    case Weekly = "Weekly";
    case Monthly = "Monthly";
    case Daily = "Daily";
    case Hourly = "Hourly";
}
