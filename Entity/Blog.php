<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use App\Enum\BlogTypeEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blogs")
 */
class Blog implements \JsonSerializable
{
	/**
	 * @ORM\Id @ORM\GeneratedValue @ORM\Column(name="id", type="integer", nullable=false)
	 * @var int
	 */
	private $id;

	/**
	 * @ORM\Column(name="title", type="text")
	 * @var string
	 */
	private $title;

	/**
	 * @ORM\Column(name="body", type="text")
	 * @var string
	 */
	private $body;

	/**
	 * @ORM\Column(name="uri", type="text")
	 * @var string
	 */
	private $uri;

	/**
	 * @ORM\Column(name="active", type="integer")
	 * @var int
	 */

	private $active;

	/**
	 * @ORM\Column(name="type", type="text")
	 * @var string
	 */
	private $type;

	/**
	 * @ORM\ManyToOne(targetEntity="BookList")
	 * @ORM\JoinColumn(name="list_id", referencedColumnName="id")
	 * @var BookList
	 */
	private $list;

	/**
	 * @ORM\Column(name="list_id", type="integer")
	 * @var string
	 */
	public $list_id;

	/**
	 * @ORM\ManyToMany(targetEntity="Video")
	 * @ORM\JoinTable(name="blog_video")
	 * @var Video[]|ArrayCollection
	 */

	private $videos;

	public function getId() {
		return $this->id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	public function getBody() {
		return $this->body;
	}

	public function setBody($body) {
		$this->body = $body;
		return $this;
	}

	public function getUri() {
		return $this->uri;
	}

	public function setUri($uri) {
		$this->uri = $uri;
		return $this;
	}

	public function getActive() {
		return (bool)$this->active;
	}

	public function setActive($active) {
		$this->active = $active;
		return $this;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	public function getList() {
		return $this->list;
	}

	public function setList($list) {
		$this->list = $list;
		return $list;
	}

	public function getVideos() {
		return $this->videos;
	}

	public function setVideos($videos) {
		$this->videos = $videos;
		return $this;
	}

	public function getListId() {
		if ($this->list) {
			return $this->list->getId();
		}
		return null;
	}

	public function getTypeTranslate() {
		return BlogTypeEnum::getTranslates()[$this->type];
	}

	public function jsonSerialize()
	{
		return array(
			'id' => $this->id,
			'title'=> $this->title,
			'body' => $this->body,
			'uri' => $this->uri,
			'active' => $this->active,
			'type' => $this->type,
			'list_id' => $this->getListId(),
			'videos' => $this->getVideos()
		);
	}
}
