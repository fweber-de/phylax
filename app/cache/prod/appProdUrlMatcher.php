<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/applications')) {
                // api_applications_collection
                if (rtrim($pathinfo, '/') === '/api/applications') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'api_applications_collection');
                    }

                    return array (  '_controller' => 'ApiBundle\\Controller\\ApplicationController::collectionAction',  '_route' => 'api_applications_collection',);
                }

                // api_applications_entity
                if (preg_match('#^/api/applications/(?P<applicationId>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_applications_entity')), array (  '_controller' => 'ApiBundle\\Controller\\ApplicationController::entityAction',));
                }

                // api_applications_entity_incidents
                if (preg_match('#^/api/applications/(?P<applicationId>[^/]++)/incidents$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_applications_entity_incidents')), array (  '_controller' => 'ApiBundle\\Controller\\ApplicationController::entityIncidentsAction',));
                }

            }

            if (0 === strpos($pathinfo, '/api/incidents')) {
                // api_incidents_collection
                if (rtrim($pathinfo, '/') === '/api/incidents') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'api_incidents_collection');
                    }

                    return array (  '_controller' => 'ApiBundle\\Controller\\IncidentController::collectionAction',  '_route' => 'api_incidents_collection',);
                }

                // api_incidents_entity
                if (preg_match('#^/api/incidents/(?P<incidentId>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_incidents_entity')), array (  '_controller' => 'ApiBundle\\Controller\\IncidentController::entityAction',));
                }

                // api_incidents_count
                if ($pathinfo === '/api/incidents/count') {
                    return array (  '_controller' => 'ApiBundle\\Controller\\IncidentController::entityTotalCountAction',  '_route' => 'api_incidents_count',);
                }

            }

            // api_testSlack
            if ($pathinfo === '/api/testSlack') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_api_testSlack;
                }

                return array (  '_controller' => 'ApiBundle\\Controller\\MiscController::testSlackAction',  '_format' => 'json',  '_route' => 'api_testSlack',);
            }
            not_api_testSlack:

        }

        // index
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'index');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\PageController::indexAction',  '_route' => 'index',);
        }

        // dashboard
        if ($pathinfo === '/dashboard') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::dashboardAction',  '_route' => 'dashboard',);
        }

        if (0 === strpos($pathinfo, '/applications')) {
            // applications_collection
            if (rtrim($pathinfo, '/') === '/applications') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'applications_collection');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\ApplicationController::collectionAction',  '_route' => 'applications_collection',);
            }

            // applications_create
            if ($pathinfo === '/applications/create') {
                return array (  '_controller' => 'AppBundle\\Controller\\ApplicationController::createAction',  '_route' => 'applications_create',);
            }

            // applications_object
            if (preg_match('#^/applications/(?P<applicationId>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'applications_object')), array (  '_controller' => 'AppBundle\\Controller\\ApplicationController::objectAction',));
            }

            // applications_update
            if (preg_match('#^/applications/(?P<applicationId>[^/]++)/update$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'applications_update')), array (  '_controller' => 'AppBundle\\Controller\\ApplicationController::updateAction',));
            }

            // applications_delete
            if (preg_match('#^/applications/(?P<applicationId>[^/]++)/delete$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'applications_delete')), array (  '_controller' => 'AppBundle\\Controller\\ApplicationController::deleteAction',));
            }

            // applications_heartbeat
            if (preg_match('#^/applications/(?P<applicationId>[^/]++)/heartbeats$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'applications_heartbeat')), array (  '_controller' => 'AppBundle\\Controller\\ApplicationController::heartbeatsAction',));
            }

            // applications_heartbeat_delete
            if (preg_match('#^/applications/(?P<applicationId>[^/]++)/heartbeats/(?P<heartbeatId>[^/]++)/delete$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'applications_heartbeat_delete')), array (  '_controller' => 'AppBundle\\Controller\\ApplicationController::deleteHeartbeatAction',));
            }

            // applications_heartbeat_monitor
            if (preg_match('#^/applications/(?P<applicationId>[^/]++)/heartbeats/(?P<heartbeatId>[^/]++)/monitor$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'applications_heartbeat_monitor')), array (  '_controller' => 'AppBundle\\Controller\\ApplicationController::monitorHeartbeatAction',));
            }

            // applications_heartbeat_edit_alias
            if (preg_match('#^/applications/(?P<applicationId>[^/]++)/heartbeats/(?P<heartbeatId>[^/]++)/alias/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'applications_heartbeat_edit_alias')), array (  '_controller' => 'AppBundle\\Controller\\ApplicationController::editHeartbeatAliasAction',));
            }

        }

        // stream
        if ($pathinfo === '/stream') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::streamAction',  '_route' => 'stream',);
        }

        if (0 === strpos($pathinfo, '/incidents')) {
            // incidents_like
            if (0 === strpos($pathinfo, '/incidents/like') && preg_match('#^/incidents/like/(?P<incidentId>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'incidents_like')), array (  '_controller' => 'AppBundle\\Controller\\IncidentController::likeAction',));
            }

            // incidents_detail
            if (preg_match('#^/incidents/(?P<incidentId>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'incidents_detail')), array (  '_controller' => 'AppBundle\\Controller\\IncidentController::detailAction',));
            }

            // incidents_silence
            if (preg_match('#^/incidents/(?P<incidentId>[^/]++)/silence$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'incidents_silence')), array (  '_controller' => 'AppBundle\\Controller\\IncidentController::silenceAction',));
            }

        }

        if (0 === strpos($pathinfo, '/tracker')) {
            // tracker_create
            if ($pathinfo === '/tracker/error') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_tracker_create;
                }

                return array (  '_controller' => 'TrackerBundle\\Controller\\ErrorController::createAction',  '_format' => 'json',  '_route' => 'tracker_create',);
            }
            not_tracker_create:

            // tracker_heartbeat
            if ($pathinfo === '/tracker/ping/heartbeat') {
                if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                    $allow = array_merge($allow, array('POST', 'OPTIONS'));
                    goto not_tracker_heartbeat;
                }

                return array (  '_controller' => 'TrackerBundle\\Controller\\PingController::heartbeatAction',  '_format' => 'json',  '_route' => 'tracker_heartbeat',);
            }
            not_tracker_heartbeat:

        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_security_login;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                }
                not_fos_user_security_login:

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_security_logout;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
            }
            not_fos_user_security_logout:

        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ($pathinfo === '/profile/edit') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_profile_edit;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
            }
            not_fos_user_profile_edit:

        }

        if (0 === strpos($pathinfo, '/re')) {
            if (0 === strpos($pathinfo, '/register')) {
                // fos_user_registration_register
                if (rtrim($pathinfo, '/') === '/register') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_registration_register;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
                }
                not_fos_user_registration_register:

                if (0 === strpos($pathinfo, '/register/c')) {
                    // fos_user_registration_check_email
                    if ($pathinfo === '/register/check-email') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_check_email;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                    }
                    not_fos_user_registration_check_email:

                    if (0 === strpos($pathinfo, '/register/confirm')) {
                        // fos_user_registration_confirm
                        if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirm;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',));
                        }
                        not_fos_user_registration_confirm:

                        // fos_user_registration_confirmed
                        if ($pathinfo === '/register/confirmed') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirmed;
                            }

                            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                        }
                        not_fos_user_registration_confirmed:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/resetting')) {
                // fos_user_resetting_request
                if ($pathinfo === '/resetting/request') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_request;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
                }
                not_fos_user_resetting_request:

                // fos_user_resetting_send_email
                if ($pathinfo === '/resetting/send-email') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_resetting_send_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                }
                not_fos_user_resetting_send_email:

                // fos_user_resetting_check_email
                if ($pathinfo === '/resetting/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_check_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                }
                not_fos_user_resetting_check_email:

                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',));
                }
                not_fos_user_resetting_reset:

            }

        }

        // fos_user_change_password
        if ($pathinfo === '/profile/change-password') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_user_change_password;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
        }
        not_fos_user_change_password:

        // fos_js_routing_js
        if (0 === strpos($pathinfo, '/js/routing') && preg_match('#^/js/routing(?:\\.(?P<_format>js|json))?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_js_routing_js')), array (  '_controller' => 'fos_js_routing.controller:indexAction',  '_format' => 'js',));
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
