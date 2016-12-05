<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use DataBundle\Entity\Application;
use Util\Helper\ApplicationHelper;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class ApplicationController extends Controller
{
    public function collectionAction()
    {
        $applications = $this->getDoctrine()->getRepository('DataBundle:Application')->findAll();

        return $this->render('Application/collection.html.twig', [
            'applications' => $applications,
        ]);
    }

    public function objectAction(Request $request, $applicationId)
    {
        /* @var $application Application */
        $application = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneById($applicationId);
        $incidents = $this->getDoctrine()->getRepository('DataBundle:Incident')->getPaginatedByApplicationId(
                $this->get('knp_paginator'), $applicationId, $request->query->get('page', 1), $request->query->get('limit', 10)
        );

        //graphs
        $appColors[$application->getName()] = $application->getColorHex();

        $data7Days = json_encode($this->get('exc.incident_graph')->getIncidentData((new \DateTime('now'))->modify('-6 days'), new \DateTime('now'), $application));
        $dataExceptions = json_encode($this->get('exc.exception_type_graph')->getData($application));

        return $this->render('Application/object.html.twig', [
            'application' => $application,
            'incidents' => $incidents,
            'appColors' => json_encode($appColors),
            'data7Days' => $data7Days,
            'dataExceptions' => $dataExceptions,
        ]);
    }

    public function createAction(Request $request)
    {
        //post
        if ($request->get('sent', 0) == 1) {
            $application = new Application();
            $application
                ->setName(ApplicationHelper::generateSlug($request->get('name')))
                ->setUrl($request->get('url'))
                ->setAppkey(ApplicationHelper::generateAppKey($request->get('name')))
                ->setColorHex($request->get('color', 'cccccc'))
                ->setEmailRecipients($request->get('recipients'))
                ->setSendEmail((bool) $request->get('sendmail', 0))
                ->setSlackUrl($request->get('slack_url'))
                ->setSendSlack((bool) $request->get('sendslack', 0))
            ;

            $validator = $this->get('validator');
            $errors = $validator->validate($application);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error);
                }

                return $this->render('Application/create.html.twig');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute('applications_collection');
        }

        return $this->render('Application/create.html.twig');
    }

    public function updateAction(Request $request, $applicationId)
    {
        /* @var $application Application */
        $application = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneById($applicationId);

        //post
        if ($request->get('sent', 0) == 1) {
            $application
                ->setName(ApplicationHelper::generateSlug($request->get('name')))
                ->setUrl($request->get('url'))
                ->setAppkey(ApplicationHelper::generateAppKey($request->get('name')))
                ->setColorHex($request->get('color', 'cccccc'))
                ->setEmailRecipients($request->get('recipients'))
                ->setSendEmail((bool) $request->get('sendmail', 0))
                ->setSlackUrl($request->get('slack_url'))
                ->setSendSlack((bool) $request->get('sendslack', 0))
            ;

            $validator = $this->get('validator');
            $errors = $validator->validate($application);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error);
                }

                return $this->render('Application/update.html.twig', array(
                            'application' => $application,
                ));
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('applications_collection');
        }

        return $this->render('Application/update.html.twig', [
            'application' => $application,
        ]);
    }

    public function deleteAction(Request $request, $applicationId)
    {
        /* @var $application Application */
        $application = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneById($applicationId);

        //post
        if ($request->get('sent', 0) == 1) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($application);
            $em->flush();

            return $this->redirectToRoute('applications_collection');
        }

        return $this->render('Application/delete.html.twig', [
            'application' => $application,
        ]);
    }

    public function heartbeatsAction($applicationId)
    {
        /* @var $application Application */
        $application = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneById($applicationId);

        return $this->render('Application/heartbeats.html.twig', [
            'application' => $application,
        ]);
    }

    public function deleteHeartbeatAction(Request $request, $applicationId, $heartbeatId)
    {
        $application = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneById($applicationId);

        if (!$application) {
            throw new \Exception(sprintf('%s is no valid ApplicationId', $applicationId));
        }

        $heartbeat = $this->getDoctrine()->getRepository('DataBundle:Heartbeat')->findOneById($heartbeatId);

        if (!$heartbeat) {
            throw new \Exception(sprintf('%s is no valid HeartbeatId', $heartbeatId));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($heartbeat);
        $em->flush();

        return $this->redirectToRoute('applications_heartbeat', [
            'applicationId' => $applicationId,
        ]);
    }

    public function monitorHeartbeatAction(Request $request, $applicationId, $heartbeatId)
    {
        $application = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneById($applicationId);

        if (!$application) {
            throw new \Exception(sprintf('%s is no valid ApplicationId', $applicationId));
        }

        $heartbeat = $this->getDoctrine()->getRepository('DataBundle:Heartbeat')->findOneById($heartbeatId);

        if (!$heartbeat) {
            throw new \Exception(sprintf('%s is no valid HeartbeatId', $heartbeatId));
        }

        $heartbeat->setMonitor(!($heartbeat->getMonitor()));

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('applications_heartbeat', [
            'applicationId' => $applicationId,
        ]);
    }

    public function editHeartbeatAliasAction(Request $request, $applicationId, $heartbeatId)
    {
        $application = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneById($applicationId);

        if (!$application) {
            throw new \Exception(sprintf('%s is no valid ApplicationId', $applicationId));
        }

        $heartbeat = $this->getDoctrine()->getRepository('DataBundle:Heartbeat')->findOneById($heartbeatId);

        if (!$heartbeat) {
            throw new \Exception(sprintf('%s is no valid HeartbeatId', $heartbeatId));
        }

        if (!$heartbeat->getMonitor()) {
            throw new \Exception(sprintf('The Heartbeat for %s is not monitored!', $heartbeat->getIp()));
        }

        if ($request->get('sent', 0) == 1) {
            $heartbeat->setAlias($request->get('alias'));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('applications_heartbeat', [
                'applicationId' => $applicationId,
            ]);
        }

        return $this->render('Application/edit_heartbeat_alias.html.twig', [
            'heartbeat' => $heartbeat,
        ]);
    }
}
