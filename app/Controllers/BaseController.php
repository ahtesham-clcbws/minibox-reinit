<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['common', 'number'];
    protected $data = array();

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {

        $this->data['data_status'] = 'global data loaded';

        $this->data['optionalJs'] = false;
        $this->data['loadSelect2'] = false;
        $this->data['paymentAssets'] = false;

        $this->data['pageName'] = 'Mini Box Office';
        $this->data['pageTitle'] = 'Mini Box Office';

        $this->data['gateway_callback'] = route_to('gatewayCallbak');
        $this->data['gateway_callback_success'] = route_to('gatewaySuccess');
        $this->data['gateway_callback_fail'] = route_to('gatewayFailed');

        // Do Not Edit This Line
        parent::initController($request, $response, $logger, $this->data);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
}
