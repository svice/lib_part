<?php
namespace App\Controller;

use Doctrine\ORM\Query;
use App\Entity\Blog;
use App\Enum\BlogTypeEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends BaseController
{
    /**
     * @Route("/blogs", name="blogs")
     */
	public function index(): JsonResponse
    {
		$query = $this->em->getRepository(Blog::class)
			->createQueryBuilder('b')
			->select(['b.id', 'b.title','b.uri', 'b.type'])
			->andWhere('b.active = 1');

		$blogs = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
		foreach ($blogs as $key => $blog) {
			if(array_key_exists($blog['type'], BlogTypeEnum::getTranslates())) {
				$blogs[$key]['typeTranslate'] = BlogTypeEnum::getTranslates()[$blog['type']];
			}
		}
		return $this->json($blogs);
	}
    /**
     * @Route("/blogs/{uri}", name="blogs_by_name")
     */
	public function findByUri(Request $request): JsonResponse
    {
		$uri = $request->get('uri');
		$blog = $this->em->getRepository(Blog::class)
			->createQueryBuilder('b')
			->leftJoin('b.videos', 'v')
			->addSelect('v')
			->andWhere('b.uri = :uri')
			->setParameter('uri', $uri)
			->getQuery()->getResult(Query::HYDRATE_ARRAY);
		return $this->json($blog);
	}
}
