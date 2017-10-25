<?php

namespace Magnetar\Log\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Magnetar\Log\Models\Log;
use Magnetar\Log\ResponseHelper;

class LogController extends Controller
{

    /**
     * Return modules list.
     *
     * @param Request $request
     * @return ResponseHelper
     */
    public function index(Request $request) {

        $out['logs'] = Log::get();

        return ResponseHelper::response_success("successful", $out);

    }

    /**
     * Return module by id.
     *
     * @param Request $request
     * @param int $id
     * @return ResponseHelper
     */
    public function show(Request $request, $id) {

        $out['log'] = Log::find($id);

        if(!$out['log'])
            return ResponseHelper::response_error("not.found", 404);

        return ResponseHelper::response_success("successful", $out);

    }

    /**
     * Create/update module.
     *
     * @param Request $request
     * @param int $id
     * @return ResponseHelper
     */
    public function process(Request $request, $id = null) {

        if($id == null)
            $log = new Log();
        else {

            $log = Log::find($id);

            if(!$log)
                return ResponseHelper::response_error("not.found", 404);

        }

        if ($log->validate($request->all())) {

            $log->text = $request->input('text');
            $log->code = $request->input('code');
            $log->level = $request->input('level');
            $log->data = $request->input('data');

            $log->save();

            return ResponseHelper::response_success("update", ['log' => $log]);

        } else
            return ResponseHelper::response_error($log->errors(), 400);

    }

    /**
     * Delete module.
     *
     * @param int $id
     * @return ResponseHelper
     */
    public function destroy($id) {

        $object_type = Log::find($id);

        if(!$object_type)
            return ResponseHelper::response_error("not.found", 404);

        $object_type->delete();

        return ResponseHelper::response_success("successful");

    }

}
