<?php
namespace Vittozich\Modulara\Modular\Core;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class CoreController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
