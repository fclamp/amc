<?php
/* KE Software Open Source Licence
** 
** Notice: Copyright (c) 2011  KE SOFTWARE PTY LTD (ACN 006 213 298)
** (the "Owner"). All rights reserved.
** 
** Licence: Permission is hereby granted, free of charge, to any person
** obtaining a copy of this software and associated documentation files
** (the "Software"), to deal with the Software without restriction,
** including without limitation the rights to use, copy, modify, merge,
** publish, distribute, sublicense, and/or sell copies of the Software,
** and to permit persons to whom the Software is furnished to do so,
** subject to the following conditions.
** 
** Conditions: The Software is licensed on condition that:
** 
** (1) Redistributions of source code must retain the above Notice,
**     these Conditions and the following Limitations.
** 
** (2) Redistributions in binary form must reproduce the above Notice,
**     these Conditions and the following Limitations in the
**     documentation and/or other materials provided with the distribution.
** 
** (3) Neither the names of the Owner, nor the names of its contributors
**     may be used to endorse or promote products derived from this
**     Software without specific prior written permission.
** 
** Limitations: Any person exercising any of the permissions in the
** relevant licence will be taken to have accepted the following as
** legally binding terms severally with the Owner and any other
** copyright owners (collectively "Participants"):
** 
** TO THE EXTENT PERMITTED BY LAW, THE SOFTWARE IS PROVIDED "AS IS",
** WITHOUT ANY REPRESENTATION, WARRANTY OR CONDITION OF ANY KIND, EXPRESS
** OR IMPLIED, INCLUDING (WITHOUT LIMITATION) AS TO MERCHANTABILITY,
** FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. TO THE EXTENT
** PERMITTED BY LAW, IN NO EVENT SHALL ANY PARTICIPANT BE LIABLE FOR ANY
** CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
** TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
** SOFTWARE OR THE USE OR OTHER DEALINGS WITH THE SOFTWARE.
** 
** WHERE BY LAW A LIABILITY (ON ANY BASIS) OF ANY PARTICIPANT IN RELATION
** TO THE SOFTWARE CANNOT BE EXCLUDED, THEN TO THE EXTENT PERMITTED BY
** LAW THAT LIABILITY IS LIMITED AT THE OPTION OF THE PARTICIPANT TO THE
** REPLACEMENT, REPAIR OR RESUPPLY OF THE RELEVANT GOODS OR SERVICES
** (INCLUDING BUT NOT LIMITED TO SOFTWARE) OR THE PAYMENT OF THE COST OF SAME.
*/
namespace Bmcd\Imu;
use Bmcd\Imu\ImuSession;
use Bmcd\Imu\ImuHandlerInterface;
use Bmcd\Imu\ImuException;

class ImuHandler
	implements ImuHandlerInterface
{
	/**
	 * @var ImuSession|null $_session
	 */
	protected $_session;

	/**
	 * @var mixed $_create
	 */
	protected $_create;

	/**
	 * @var mixed $_destroy
	 */
	protected $_destroy;

	/**
	 * @var mixed $_id
	 */
	protected $_id;

	/**
	 * @var mixed $_language
	 */
	protected $_language;

	/**
	 * @var mixed $_name
	 */
	protected $_name;

	/**
	 * Class constructor
	 *
	 * @param mixed $session
	 * @return \ImuHandler
	 */
	public function __construct($session = null)
	{
		if ($session == null)
			$this->_session = new IMuSession;
		else
			$this->_session = $session;

		$this->_create = null;
		$this->_destroy = null;
		$this->_id = null;
		$this->_language = null;
		$this->_name = null;
	}

	/**
	 * Get create.
	 *
	 * @param void
	 * @return mixed
	 * @access public
	 */
	public function getCreate()
	{
		return $this->_create;
	}

	/**
	 * Set create.
	 *
	 * @param mixed $create
	 * @return void
	 * @access public
	 */
	public function setCreate($create)
	{
		$this->_create = $create;
	}

	/**
	 * Get destroy.
	 *
	 * @param void
	 * @return mixed
	 * @access public
	 */
	public function getDestroy()
	{
		if ($this->_destroy == null)
			return false;
		return $this->_destroy;
	}

	/**
	 * Set destroy.
	 *
	 * @param mixed $destroy
	 * @return void
	 * @access public
	 */
	public function setDestroy($destroy)
	{
		$this->_destroy = $destroy;
	}

	/**
	 * Get ID.
	 *
	 * @param void
	 * @return mixed
	 * @access public
	 */
	public function getID()
	{
		return $this->_id;
	}

	/**
	 * Set ID.
	 *
	 * @param mixed $id
	 * @return void
	 * @access public
	 */
	public function setID($id)
	{
		$this->_id = $id;
	}

	/**
	 * Get language.
	 *
	 * @param void
	 * @return string
	 * @access public
	 */
	public function getLanguage()
	{
		return $this->_language;
	}

	/**
	 * Set language.
	 *
	 * @param string $language
	 * @return void
	 * @access public
	 */
	public function setLanguage($language)
	{
		$this->_language = $language;
	}

	/**
	 * Get name.
	 *
	 * @param void
	 * @return string
	 * @access public
	 */
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * Set name.
	 *
	 * @param string $name
	 * @return void
	 * @access public
	 */
	public function setName($name)
	{
		$this->_name = $name;
	}

	/**
	 * Get session.
	 *
	 * @param void
	 * @return ImuSession
	 * @access public
	 */
	public function getSession()
	{
		return $this->_session;
	}

	/**
	 * Magic getter.
	 *
	 * @param string $name
	 * @return mixed
	 * @access public
	 */
	public function __get($name)
	{
		switch ($name)
		{
		  case 'create':
		  	return $this->getCreate();
		  case 'destroy':
		  	return $this->getDestroy();
		  case 'id':
		  	return $this->getID();
		  case 'language':
		  	return $this->getLanguage();
		  case 'name':
		  	return $this->getName();
		  case 'session':
		  	return $this->getSession();
		  default:
		  	throw new ImuException('HandlerProperty', $name);
		}
	}

	/**
	 * Magic setter.
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return mixed
	 * @access public
	 */
	public function __set($name, $value)
	{
		switch ($name)
		{
		  case 'create':
		  	return $this->setCreate($value);
		  case 'destroy':
		  	return $this->setDestroy($value);
		  case 'id':
		  	return $this->setID($value);
		  case 'language':
		  	return $this->setLanguage($value);
		  case 'name':
		  	return $this->setName($value);
		  case 'session':
		  	throw new IMuException('HandlerSessionReadOnly');
		  default:
		  	throw new IMuException('HandlerProperty', $name);
		}
	}

	/**
	 * Caller.
	 *
	 * @param string $method
	 * @param mixed $params
	 * @return mixed
	 * @access public
	 */
	public function call($method, $params = null)
	{
		$request = array();
		$request['method'] = $method;
		if ($params != null)
			$request['params'] = $params;
		$response = $this->request($request);
		return $response['result'];
	}

	/**
	 * Request.
	 *
	 * @param mixed $request
	 * @return mixed
	 * @access public
	 */
	public function request($request)
	{
		if ($this->_id != null)
			$request['id'] = $this->_id;
		else if ($this->_name != null)
		{
			$request['name'] = $this->_name;
			if ($this->_create != null)
				$request['create'] = $this->_create;
		}
		if ($this->_destroy != null)
			$request['destroy'] = $this->_destroy;
		if ($this->_language != null)
			$request['language'] = $this->_language;

		$response = $this->_session->request($request);

		if (array_key_exists('id', $response))
			$this->_id = $response['id'];

		return $response;
	}
}
