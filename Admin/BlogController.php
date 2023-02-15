<?php
namespace App\Controller\Admin;

use App\Controller\AbstractControllerProvider;
use App\Controller\BaseController;
use App\Entity\Blog;
use App\Entity\Book;
use App\Entity\Factoid;
use App\Form\FormType\Admin\Factoid\FactoidEditFormType;
use App\Form\FormType\Entity\BlogFormType;
use App\Form\FormType\Entity\FactoidFormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends BaseController
{
    /**
     * @Route("/admin/blog", name="admin_blogs")
     */
	public function index()
	{
		$blogs = $this->em->getRepository('App\Entity\Blog')
			->createQueryBuilder('b');

		$blogs = $this->app->pagination($blogs);

		return $this->render('admin/blog/list.twig', [
			'blogs'  => $blogs,
		]);
	}

    /**
     * @Route("/admin/blog/{blog_id}/edit", name="admin_blog_edit")
     */
	public function edit(Request $request)
	{

		$blog = $this->em->getRepository(Blog::class)
			->find($this->app->getRequest()->get('blog_id'));

        $form = $this->createForm(BlogFormType::class, $blog)
			->add('save', SubmitType::class, [
				'label' => 'Сохранить',
			]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			$blog = $form->getData();
			$this->em->persist($blog);
			$this->em->flush();

			return $this->app->redirectCurrent('success', 'Сохранено');
		}

		return $this->render('admin/blog/add.twig', [
			'blog'  => $blog,
			'form' => $form->createView(),
		]);
	}
    /**
     * @Route("/admin/blog/{blog_id}/delete", name="admin_blog_delete")
     */
	public function deleteBlog()
	{
		$blog = $this->em->getRepository('App\Entity\Blog')->find($this->app->getRequest()->get('blog_id'));
		$this->em->remove($blog);
		$this->em->flush();

		return $this->redirectRoute('admin_blogs', 'success', 'Статья удалена');
	}

    /**
     * @Route("/admin/blog/add", name="admin_blog_add")
     */
	public function add(Request $request)
	{
		$form = $this->createForm(BlogFormType::class, new Blog())
			->add('add', SubmitType::class, [
				'label' => 'Добавить',
			]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			/** @var Book $blog */
			$blog = $form->getData();
			$this->em->persist($blog);
			$this->em->flush();

			return $this->redirectRoute('admin_blog_edit', null, null, [
				'blog_id' => $blog->getId()
			]);
		}

		return $this->render('admin/blog/add.twig', [
			'form' => $form->createView()
		]);
	}
}
