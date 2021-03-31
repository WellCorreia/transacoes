<?php

namespace App\Exceptions;

use Exception;

class ObjectNotFoundException extends Exception
{

    /**
    * Report the exception.
    *
    * @return void
    */
   public function report()
   {
       //
   }

   /**
    * Render the exception into an HTTP response.
    *
    * @param  \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
   public function render($request, Exception $exception)
   {
       if ($exception instanceof ObjectNotFoundException) {
        return response()->json(['error' => 'Object not found'], 400);
       }

       return parent::render($request, $exception);
   }
}
