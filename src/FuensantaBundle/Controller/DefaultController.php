<?php

namespace FuensantaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncode;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FuensantaBundle:Default:index.html.twig');
    }

    /**
     * @return JsonResponse
     */
    public function articlesListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('FuensantaBundle:Article')->findAll();

        $response = array();

        foreach($articles as $article)
        {
            $a = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'date' => $article->getDate(),
                'category' => $article->getCategory()
            ];

            $response[] = $a;
        }

        return new JsonResponse($response);
    }

    /**
     * @return JsonResponse
     */
    public function fairsListAction(){
        $em = $this->getDoctrine()->getManager();

        $fairs = $em->getRepository('FuensantaBundle:Fair')->findAll();

        $response = array();
        
        foreach ($fairs as $fair)
        {
            $f = [
                'id' => $fair->getId(),
                'name' => $fair->getName(),
                'date' => date_format($fair->getDate(), 'd-m-Y')
            ];
            
            $response[] = $f;

            return new JsonResponse($response);
        }
    }
    
    /**
     * @return JsonResponse
     */
    public function eventsListAction($fair_id)
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('FuensantaBundle:Event')->findBy( array('fair' => $fair_id));

        $response = array();

        foreach($events as $event)
        {
            $a = [
                'id' => $event->getId(),
                'title' => $event->getTitle(),
                'content' => $event->getDescription(),
                'date' => date_format($event->getDate(), 'd-m-Y'),
                'time' => date_format($event->getTime(), 'H:i')
            ];

            $response[] = $a;
        }

        return new JsonResponse($response);
    }

    public function getArticlesByCategoryAction($category_id)
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('FuensantaBundle:Article')->findBy(array('category' => $category_id));

        $response = array();

        foreach($articles as $article)
        {
            $a = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'date' => $article->getDate()
            ];

            $response[] = $a;
        }

        return new JsonResponse($response);
    }
}
