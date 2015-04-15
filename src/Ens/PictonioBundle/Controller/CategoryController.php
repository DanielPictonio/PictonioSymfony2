<?php

namespace Ens\PictonioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ens\PictonioBundle\Entity\Category;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller {

    public function showAction($slug, $page) {
        $em = $this->getDoctrine()->getEntityManager();

        $category = $em->getRepository('EnsPictonioBundle:Category')->findOneBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $total_jobs = $em->getRepository('EnsPictonioBundle:Job')->countActiveJobs($category->getId());
        $jobs_per_page = $this->container->getParameter('max_jobs_on_category');
        $last_page = ceil($total_jobs / $jobs_per_page);
        $previous_page = $page > 1 ? $page - 1 : 1;
        $next_page = $page < $last_page ? $page + 1 : $last_page;

        $category->setActiveJobs($em->getRepository('EnsPictonioBundle:Job')->getActiveJobs($category->getId(), $jobs_per_page, ($page - 1) * $jobs_per_page));
        $format = $this->getRequest()->getRequestFormat();

        return $this->render('EnsPictonioBundle:Category:show.' . $format . '.twig', array(
                    'category' => $category,
                    'last_page' => $last_page,
                    'previous_page' => $previous_page,
                    'current_page' => $page,
                    'next_page' => $next_page,
                    'total_jobs' => $total_jobs,
                    'feedId' => sha1($this->get('router')->generate('EnsPictonioBundle_category', array('slug' => $category->getSlug(), '_format' => 'atom'), true)),
        ));
    }

}
