<?php
/**
 *
 * @copyright (C), 2013-, King.
 * @name Main.php
 * @author King
 * @version Beta 1.0
 * @Date 2021年8月24日下午6:51:23
 * @Description
 * @Class List 1.
 * @Function List 1.
 * @History King 2021年8月24日下午6:51:23 第一次建立该文件
 *          King 2021年8月24日下午6:51:23 修改
 *         
 */
namespace App\Controller;

use Tiny\MVC\Controller\Controller;
use App\Model\Main\UserInfo;
use Tiny\Lang\Lang;
use Tiny\Config\Configuration;
use Tiny\MVC\Request\Param\Get;
use Tiny\Cache\Storager\PHP;
use Tiny\MVC\Web\HttpSession;
use Tiny\MVC\Web\HttpCookie;
use Tiny\MVC\View\View;
use App\Model\Main\User\UserInfoByRedis;
use Tiny\Net\IpArea;
use Tiny\MVC\Application\Properties;
use Tiny\Cache\Storager\SingleCache;
use Tiny\DI\ContainerInterface;
use App\Common\Bootstrap;
use Tiny\Cache\Cache;

/**
 * an example of main controller
 */
class Main extends Controller
{
    /**
     * @autowired
     * 
     * @var UserInfo 
     */
    protected UserInfo $userinfoModel;

    /**
     * 
     * @param HttpCookie $cookie 
     * @param Get $get
     * @param UserInfo $userinfoModel
     * @param PHP $cache
     * @param Configuration $config
     * @param Lang $lang
     * @param HttpSession $session
     * @param View $view
     */
    public function indexAction(Get $get,Lang $lang, HttpSession $session, HttpCookie $cookie, \App\Model\Main\User\UserInfo $userinfoModel, Configuration $config, Cache $cache)
    {
        // session
        if (!$session['username']) {
         //   $session['username'] = 'dajin';
        }
      // $container->get('bootstrap');   
        // cookie
        if (!$cookie['uid']) {
          //  $cookie['uid'] = '100';
        }
        
        // $request->get
        $actionName = $get->formatString('a');
        $pageid = $this->request->get['pageid'];
        
        $controllerName = $this->request->getControllerName();
        
        // request->filter
        $name = $this->request->get->formatString('name', 'tinyphp');
        $isName = $this->request->get->isRequired('name') ? 'true' : 'false';
        
        // lang
        echo $lang->translate('status.0','sss');
        echo $config['example.default.b'];
        
        $userInfo = $userinfoModel->getUsers();
        
        // cached
        $cached = $cache->get('aa');
        if (!$cached) {
            $cached = 'aaaax';
            $cache->set('aa', $cached);
        }
        
        $this->assign([
            'ip' => $this->request->ip,
            'iparea' => IpArea::get($this->request->ip),
            'actionName' => $actionName,
            'controllerName' => $controllerName,
            'name' => $name,
            'username' => $session['username'],
            'uid' => $cookie['uid'],
            'defName' => 'tinyphp',
            'isName' => $isName,
            'users' => $userInfo,
            'cached' => $cached,
            'pageid' => $pageid,
        ]);
     $this->display('main/index.htm');
    }
    
    /**
     * 测试smarty模板引擎
     */
    public function tplAction()
    {
        $actionName = $this->request->get->formatString('a');
        $controllerName = $this->request->get->formatString('c');
        $name = $this->request->get->formatString('name', 'tinyphp');
        $isName = $this->request->get->isRequired('name') ? 'true' : 'false';

        $this->assign([
            'actionName' => $actionName,
            'controllerName' => $controllerName,
            'name' => $name,
            'defName' => 'tinyphp',
            'isName' => $isName,
            'users' => $userInfo,
            'users1' => $userInfo1
        ]);
        $this->display('main/index.tpl');
    }
    
    /**
     * template php file
     */
    public function indexRedisAction(UserInfoByRedis $userinfoModel)
    {
        $actionName = $this->request->get->formatString('a');
        $controllerName = $this->request->get->formatString('c');
        $name = $this->request->get->formatString('name', 'tinyphp');
        $isName = $this->request->get->isRequired('name') ? 'true' : 'false';
        
        // 模型使用
        $userInfo = (array)$userinfoModel->getUsers();
        $this->assign([
            'actionName' => $actionName,
            'controllerName' => $controllerName,
            'name' => $name,
            'defName' => 'tinyphp',
            'isName' => $isName,
            'users' => $userInfo
        ]);
        $this->parse('main/index.htm');
    }
    
    /**
     * template php file
     */
    public function index1Action()
    {
        $actionName = $this->request->get->formatString('a');
        $controllerName = $this->request->get->formatString('c');
        $name = $this->request->get->formatString('name', 'tinyphp');
        $isName = $this->request->get->isRequired('name') ? 'true' : 'false';
        
        // 模型使用
        $userInfo = $this->mainUserInfoModel->getUsers();
        $this->assign([
            'actionName' => $actionName,
            'controllerName' => $controllerName,
            'name' => $name,
            'defName' => 'tinyphp',
            'isName' => $isName,
            'users' => $userInfo,
        ]);
        $this->parse('main/index.htm');
    }
    /**
     * out json
     */
    public function apiAction()
    {
        $this->response->outFormatJSON(0, ' say hello world', ['name' => 'tinyphp']);
    }
    
    /**
     * an example of using lang packs
     *
     * @param
     *        void
     * @return void
     */
    public function langAction()
    {
        $frameworksName = $this->lang['frameworks_name'];
        $this->response->outFormatJSON('0', $frameworksName, ['aaa']);
    }
    
    /**
     * an example of using cookies
     *
     * profile cookie node
     * $profile['cookie']['domain'] = '';
     * $profile['cookie']['path'] = '/';
     * $profile['cookie']['expires'] = 3600;
     * $profile['cookie']['prefix'] = '';
     * $profile['cookie']['encode'] = FALSE;
     */
    public function cookieAction()
    {
        $this->cookie->set('frameworksName', $this->lang['frameworks_name']);
        $frameworksName = $this->cookie->get('frameworksName');
        $this->response->appendBody($frameworksName);
    }
    
    /**
     * an example of using configs
     */
    public function configAction()
    {
        $example = [
            'default' => $this->config['example.default'],
            'custom' => $this->config['example.custom.name'],
            'setting' => $this->config->get('example.setting')
        ];
        $exampleStr = var_export($example, TRUE);
        $this->response->appendBody($exampleStr);
    }
    
    /**
     * an example of using caches
     */
    public function cacheAction()
    {
       //Cache::getInstance();

        $example = $this->cache->get('example.name');
        if (!$example)
        {
            $example = [
                'name' => 'tinyphp'
            ];
            $this->cache->set('example.name', $example, 60);
        }
        $this->response->appendBody(var_export($example, TRUE));
        
        /* cache id */
        $example = $this->cache['default']->get('example.name1');
        if (!$example)
        {
            $example = [
                'name' => 'tinyphp'
            ];
            $this->cache->set('example.name1', $example, 60);
        }
        $this->response->appendBody(var_export($example, TRUE));
    }
    
    /**
     * an example of using sessions
     */
    public function sessionAction()
    {
        $this->session['frameworksname'] = 'tinyphp';
        $fname = $this->session['frameworksname'];
        $this->response->appendBody($fname);
        
    }
}
?>