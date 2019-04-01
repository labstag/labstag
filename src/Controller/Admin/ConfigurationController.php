<?php

namespace App\Controller\Admin;

use App\Entity\Configuration;
use App\Form\Admin\ConfigurationType;
use App\Repository\ConfigurationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Lib\AbstractControllerLib;

/**
 * @Route("/admin/configuration")
 */
class ConfigurationController extends AbstractControllerLib
{
    /**
     * @Route("/", name="adminconfiguration_index", methods={"GET"})
     */
    public function index(ConfigurationRepository $configurationRepository): Response
    {
        $configurations = $configurationRepository->findAll();
        $this->paginator($configurations);
        return $this->render('admin/configuration/index.html.twig');
    }

    /**
     * @Route("/new", name="adminconfiguration_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $configuration = new Configuration();
        $form = $this->createForm(ConfigurationType::class, $configuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($configuration);
            $entityManager->flush();

            return $this->redirectToRoute('adminconfiguration_index');
        }

        return $this->render(
            'admin/configuration/new.html.twig',
            [
                'configuration' => $configuration,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="adminconfiguration_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Configuration $configuration): Response
    {
        $form = $this->createForm(ConfigurationType::class, $configuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adminconfiguration_index', [
                'id' => $configuration->getId(),
            ]);
        }

        return $this->render('admin/configuration/edit.html.twig', [
            'configuration' => $configuration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="adminconfiguration_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Configuration $configuration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$configuration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($configuration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adminconfiguration_index');
    }
}