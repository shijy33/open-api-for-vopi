<?php
/**
 * File    libraries\VOP\Process\Request.php
 * Desc    请求预处理模块
 * Manual  svn://svn.vop.com/api/manual/Plugin/Request
 * version 1.0.0
 * User    duanchi <http://weibo.com/shijingye>
 * Date    2013-11-23
 * Time    16:15
 */

namespace Process;


class RequestModel {

    /**
     * Function pretreatment
     * @param $_get
     * @param $_post
     * @param $_version
     * @param $_scope
     * @param $_interface
     * @return array
     */
    public static function get($_http_method, $_mvc_parameters) {
        $_request = [
            'method'        => HTTP_GET,
            'url'           => [],
            'api'           => [
                'service'       => '',
                'method'        => '',
                'resource'      => '',
            ],
            'content-type'  => TYPE_JSON,
            'version'       => REQUEST_VERSION_NULL,
            'ranges'        => [
                'columns'       => NULL,
                'order'         => NULL,
                'limit'         => NULL,
            ],

            'access-token'  => NULL,
            'client-token'  => NULL,
            'client-id'     => NULL,
            'client-ip'     => NULL,

            'content'       => [],
        ];

        //MAKE URL REQUEST
        $_request['method']         = constant('HTTP_'.$_http_method);

        $_request['url']            = $_SERVER['REQUEST_URI'];

        isset($_mvc_parameters['_service'])  && !empty($_mvc_parameters['_service'])  ? $_request['api']['service']  = $_mvc_parameters['_service']  : FALSE;
        isset($_mvc_parameters['_method'])   && !empty($_mvc_parameters['_method'])   ? $_request['api']['method']   = $_mvc_parameters['_method']   : FALSE;
        isset($_mvc_parameters['_resource']) && !empty($_mvc_parameters['_resource']) ? $_request['api']['resource'] = $_mvc_parameters['_resource'] : FALSE;

        //MAKE HTTP HEADER REQUEST
        $_tmp_header_request            = [];
        $_tmp_http_accept               = explode(';', str_replace(' ', '', strtolower($_SERVER['HTTP_ACCEPT'])));

        $_request['content-type']   = (($_tmp_http_accept[0] == TYPE_JSON) || ($_tmp_http_accept[0] == TYPE_MSGPACK) ? $_tmp_http_accept[0] : TYPE_NULL);

        if (isset($_tmp_http_accept[1]) && !empty($_tmp_http_accept[1])) {
            $_tmp = explode('=', $_tmp_http_accept[1]);
            isset($_tmp[1]) && !empty($_tmp[1]) ? $_request['version'] = $_tmp[1] : FALSE;
        }

        //@todo Ranges


        isset($_SERVER['HTTP_ACCESS_TOKEN']) ? $_request['access-token'] = $_SERVER['HTTP_ACCESS_TOKEN'] : FALSE;

        isset($_SERVER['HTTP_CLIENT_TOKEN']) ? $_request['client-token'] = $_SERVER['HTTP_CLIENT_TOKEN'] : FALSE;

        isset($_SERVER['HTTP_CLIENT_ID'])    ? $_request['client-id']    = $_SERVER['HTTP_CLIENT_ID']    : FALSE;

        isset($_SERVER['REMOTE_ADDR'])       ? $_request['client-ip']    = $_SERVER['REMOTE_ADDR']       : FALSE;

        //MAKE CONTENT REQUEST
        $_request['content'] = file_get_contents('php://input');
        switch ($_request['content-type']) {
            case TYPE_MSGPACK :
                $_request['content'] = msgpack_unpack($_request['content']);
                break;

            case TYPE_JSON :
                $_request['content'] = json_decode($_request['content']);
                break;

            case TYPE_NULL :
            default :
                $_request['content'] = NULL;
                break;
        }

        return $_request;
    }

    private static function check_service($_name, $_type = 'service') {
        $_result = FALSE;
        $_conf = \Yaf\Registry::get('service');
        switch($_type) {

            case 'method':
                if (isset($_conf['method'][$_name]) && ($_conf['method'][$_name] == '1')) {
                    $_result = TRUE;
                }
                break;

            case 'service':
            default:
                if (isset($_conf['service'][$_name]) && ($_conf['service'][$_name] == '1')) {
                    $_result = TRUE;
                }
                break;
        }

        return $_result;
    }
}