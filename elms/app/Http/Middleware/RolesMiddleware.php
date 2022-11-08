<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Roles\Menu;
use Illuminate\Support\Facades\Auth;

class RolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_group_id = Auth::user()->user_group_id;
        /*
                 * Retrieves the action from request and gets the Controller Name and Method Name
                 */
        $action = app('request')->route()->getAction();

        /*
         * Splits the controller and store in array
         */
        $controllers = explode("@", class_basename($action['controller']));
        /*
         * Checks the existence of controller and method
         */
        $controller_name = isset($controllers[0]) ? $controllers[0] : '';
        $method_name = isset($controllers[1]) ? $controllers[1] : '';


        /*
         *List of controller where permissions are not necessary
         */

        $publicController = ['HomeController', 'FeedbackController'];

        /*
         * checks the controller in array where permission are not allowed
         */
        if (!in_array($controller_name, $publicController)) {

            $user_group_id = Auth::user()->user_group_id;

            /*
             * Joins User Roles and Menus on the basis of user_group_id from user_roles and menu_controller from menus
             */
            $res = Menu::join('user_roles', 'menus.id', '=', 'user_roles.menu_id')
            ->select('user_roles.*', 'menus.*')
            ->where('user_group_id', '=', $user_group_id)
                ->where('menu_controller', '=', $controller_name)
                ->first();

            $cnt = empty($res);
            if ($cnt) {
                $this->sorry();
            } else {

                /*
                 * List of method where permissions are checked
                 */
                $arr = ['index', 'create', 'edit', 'destroy', 'show'];

                /*
                 * Search whether the method name exist in the array
                 */
                if (in_array($method_name, $arr)) {

                    $isView = $res->allow_view;
                    $isAdd = $res->allow_add;
                    $isEdit = $res->allow_edit;
                    $isDelete = $res->allow_delete;

                    switch ($method_name) {
                        case  'index':
                            if ($isView != 1) {
                                $this->sorry();
                            }
                            break;
                        case  'create':
                            if ($isAdd != 1) {
                                $this->sorry();
                            }
                            break;
                        case  'edit':
                            if ($isEdit != 1) {
                                $this->sorry();
                            }
                            break;
                        case  'destroy':
                            if ($isDelete != 1) {
                                $this->sorry();
                            }
                            break;
                        case  'show':
                            if ($isView != 1) {
                                $this->sorry();
                            }
                            break;
                    }
                }
            }
        }

        return $next($request);
    }

    function sorry()
    {
        abort(404);
    }
}
