<?php

namespace App\Nova;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

abstract class ReadOnlyResource extends Resource
{
    public static function authorizeToCreate(Request $request) {throw new AuthorizationException();}
    public static function authorizedToCreate(Request $request) {return false;}
    public function authorizeToUpdate(Request $request) {return false;}
    public function authorizedToUpdate(Request $request) {return false;}
    public function authorizeToReplicate(Request $request) {return false;}
    public function authorizedToReplicate(Request $request) {return false;}
    public function authorizeToDelete(Request $request) {return false;}
    public function authorizedToDelete(Request $request) {return false;}
    public function authorizedToRestore(Request $request) {return false;}
    public function authorizedToForceDelete(Request $request) {return false;}
    public function authorizedToAttachAny(Request $request, $model) {return false;}
    public function authorizedToAttach(Request $request, $model) {return false;}
    public function authorizedToDetach(Request $request, $model, $relationship) {return false;}
    public function authorizedToImpersonate(Request $request) {return false;}
}
