<?php
/**
 * File    application\plugin\Api.php
 * Desc    请求预处理插件模块
 * Manual  svn://svn.vop.com/api/manual/plugin/Process
 * version 1.0.0
 * User    duanchi <http://weibo.com/shijingye>
 * Date    2013-11-22
 * Time    20:36
 */
namespace Hook;

class ResponsePlugin extends \Yaf\Plugin_Abstract {

    public function dispatchLoopShutdown(\Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response) {


        if ($request->controller == 'Api') {

            $_REQUEST = \Core\KEY::get('_REQUEST');
            $_RESPONSE = \Core\KEY::get('_RESPONSE');
            $_ECHO = '';

            switch ($_REQUEST['content-type']) {
                /*case TYPE_JSONP:
                    $_result = ($_callback == NULL ? '' : $_callback) .'('.json_encode($_object, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE).');';
                    break;*/

                case TYPE_MSGPACK:
                    $_ECHO = msgpack_pack($_RESPONSE);
                    break;

                case TYPE_JSON:
                    $_ECHO = json_encode($_RESPONSE);
                    break;

                default:

                    break;
            }

            \Core\RESPONSE::initialize($response, RESPONSE_TYPE_YAF);
            \Core\RESPONSE::set($_ECHO, RESPONSE_TYPE_BODY);
            \Core\RESPONSE::respond();
        }

    }
} 