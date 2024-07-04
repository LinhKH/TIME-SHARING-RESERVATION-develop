<?php
namespace Devture\Bundle\UserBundle\Model;

use Devture\Component\DBAL\Model\BaseModel;

class UserFile extends BaseModel {

	private $user;
	private $data;

	const TYPE_PHOTO = 'photo';

	public function getS3ObjectKey() {
		return sprintf('user/%d/%s/%s.%s', $this->getUser()->getId(), $this->getType(), $this->getId(), $this->getExtension());
	}

	public function setCreationTime($value) {
		$this->setAttribute('creation_time', $value);
	}

	public function getCreationTime() {
		$value = $this->getAttribute('creation_time', null);
		return ($value === null ? null : (int) $value);
	}

	public function setType($value) {
		$this->setAttribute('type', $value);
	}

	public function getType() {
		return $this->getAttribute('type', null);
	}

	public function setName($value) {
		$this->setAttribute('name', trim($value));
	}

	public function getName() {
		return $this->getAttribute('name', '');
	}

	public function setExtension($value) {
		$this->setAttribute('extension', trim($value));
	}

	public function getExtension() {
		return $this->getAttribute('extension', null);
	}

	public function setWidth($value) {
		$this->setAttribute('width', $value);
	}

	public function getWidth() {
		$value = $this->getAttribute('width', null);
		return ($value === null ? null : (int) $value);
	}

	public function setHeight($value) {
		$this->setAttribute('height', $value);
	}

	public function getHeight() {
		$value = $this->getAttribute('height', null);
		return ($value === null ? null : (int) $value);
	}

	public function setUser(User $value = null) {
		$this->user = $value;
	}

	public function getUser() {
		return $this->user;
	}

	public function setData($data) {
		$this->data = $data;
	}

	public function getData() {
		return $this->data;
	}

	public function getContentType() {
		return 'image/' . ($this->getExtension() === 'jpg' ? 'jpeg' : $this->getExtension());
	}

}
