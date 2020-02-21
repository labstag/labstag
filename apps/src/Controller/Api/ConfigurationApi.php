<?php

namespace Labstag\Controller\Api;

use Knp\Component\Pager\PaginatorInterface;
use Labstag\Entity\Configuration;
use Labstag\Handler\ConfigurationPublishingHandler;
use Labstag\Lib\ApiControllerLib;
use Labstag\Repository\ConfigurationRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ConfigurationApi extends ApiControllerLib
{

    /**
     * @var ConfigurationPublishingHandler
     */
    protected $publishingHandler;

    public function __construct(
        ConfigurationPublishingHandler $handler,
        ContainerInterface $container,
        PaginatorInterface $paginator,
        RequestStack $requestStack,
        RouterInterface $router,
        LoggerInterface $logger
    )
    {
        parent::__construct($container, $paginator, $requestStack, $router, $logger);
        $this->publishingHandler = $handler;
    }

    public function __invoke(Configuration $data): Configuration
    {
        $this->publishingHandler->handle($data);

        return $data;
    }

    /**
     * @Route("/api/configurations/trash", name="api_configurationtrash")
     */
    public function trash(ConfigurationRepository $repository): Response
    {
        return $this->trashAction($repository);
    }

    /**
     * @Route("/api/configurations/trash", name="api_configurationtrashdelete", methods={"DELETE"})
     */
    public function delete(ConfigurationRepository $repository): JsonResponse
    {
        return $this->deleteAction($repository);
    }

    /**
     * @Route("/api/configurations/restore", name="api_configurationrestore", methods={"POST"})
     */
    public function restore(ConfigurationRepository $repository): JsonResponse
    {
        return $this->restoreAction($repository);
    }

    /**
     * @Route("/api/configurations/empty", name="api_configurationempty", methods={"POST"})
     */
    public function vider(ConfigurationRepository $repository): JsonResponse
    {
        return $this->emptyAction($repository);
    }
}