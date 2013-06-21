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
use Bmcd\Imu\ImuException;
use Bmcd\Imu\ImuStream;
use Bmcd\Imu\ImuTrace;

class ImuSession
	implements ImuSessionInterface
{
	/**
	 * @var string $_defaultHost
	 */
	private static $_defaultHost = '127.0.0.1';

	/**
	 * @var int $_defaultPort
	 */
	private static $_defaultPort = 40000;

	/**
	 * @var mixed $_close
	 */
	private $_close;

	/**
	 * @var mixed $_context
	 */
	private $_context;

	/**
	 * @var string $_host
	 */
	private $_host;

	/**
	 * @var int $_host
	 */
	private $_port;

	/**
	 * @var mixed $_socket
	 */
	private $_socket;

	/**
	 * @var mixed $_stream
	 */
	private $_stream;

	/**
	 * @var bool $_suspend
	 */
	private $_suspend;

	/**
	 * Get default host.
	 *
	 * @param void
	 * @return string
	 * @access public
	 */
	public static function getDefaultHost()
	{
		return self::$_defaultHost;
	}

	/**
	 * Set default host.
	 *
	 * @param string $host
	 * @return void
	 * @access public
	 */
	public static function setDefaultHost($host)
	{
		self::$_defaultHost = $host;
	}

	/**
	 * Get default port.
	 *
	 * @param void
	 * @return int
	 * @access public
	 */
	public static function getDefaultPort()
	{
		return self::$_defaultPort;
	}

	/**
	 * Set the default port.
	 *
	 * @param int $port
	 * @return void
	 * @access public
	 */
	public static function setDefaultPort($port)
	{
		self::$_defaultPort = $port;
	}

	/**
	 * Class constructor.
	 *
	 * @param string $host
	 * @param int $port
	 * @return \ImuSession
	 */
	public function __construct($host = null, $port = null)
	{
		$this->initialise();
		if ($host != null)
			$this->_host = $host;
		if ($port != null)
			$this->_port = $port;
	}

	/**                  
	 * Get close.
	 *           
	 * @param void
	 * @return bool|mixed
	 * @access public
	 */
	public function getClose()
	{
		if ($this->_close == null)
			return false;
		return $this->_close;
	}

	/**             
	 * Set close.    
	 * 
	 * @param mixed $close
	 * @return void
	 * @access public
	 */
	public function setClose($close)
	{
		$this->_close = $close;
	}

	/**             
	 * Get context.
	 *             
	 * @param void
	 * @return mixed
	 * @access public
	 */
	public function getContext()
	{
		return $this->_context;
	}

	/**               
	 * Set context
	 *  
	 * @param mixed $context
	 * @return void
	 * @access public
	 */
	public function setContext($context)
	{
		$this->_context = $context;
	}

	/**                   
	 * Get host.
	 * 
	 * @param void
	 * @return null|string
	 * @access public
	 */
	public function getHost()
	{
		return $this->_host;
	}

	/**            
	 * Set host.     
	 * 
	 * @param string $host
	 * @return void
	 * @access public
	 */
	public function setHost($host)
	{
		$this->_host = $host;
	}

	/**                
	 * Get port.
	 * 
	 * @param void
	 * @return int|null
	 * @access public
	 */
	public function getPort()
	{
		return $this->_port;
	}

	/**            
	 * Set port.
	 * 
	 * @param int $port
	 * @return void
	 * @access public
	 */
	public function setPort($port)
	{
		$this->_port = $port;
	}

	/**            
	 * Get suspend.
	 *             
	 * @param void
	 * @return bool
	 * @access public
	 */
	public function getSuspend()
	{
		if ($this->_suspend == null)
			return false;
		return $this->_suspend;
	}

	/**               
	 * Set suspend.
	 *        
	 * @param mixed $suspend
	 * @return void
	 * @access public
	 */
	public function setSuspend($suspend)
	{
		$this->_suspend = $suspend;
	}

	/**                    
	 * Magic getter.
	 * 
	 * @param $name
	 * @return bool|int|mixed|null|string
	 * @throws \ImuException
	 * @access public
	 */
	public function __get($name)
	{
		switch ($name)
		{
		  case 'close':
		  	return $this->getClose();
			break;
		  case 'context':
		  	return $this->getContext();
			break;
		  case 'host':
		  	return $this->getHost();
			break;
		  case 'port':
		  	return $this->getPort();
			break;
		  case 'suspend':
		  	return $this->getSuspend();
			break;
		  default:
		  	throw new ImuException('SessionProperty', $name);
		}
	}

	/**              
	 * Magic setter.
	 * 
	 * @param string $name
	 * @param string $value
	 * @return mixed
	 * @throws \ImuException
	 * @access public
	 */
	public function __set($name, $value)
	{
		switch ($name)
		{
		  case 'close':
		  	return $this->setClose($value);
			break;
		  case 'context':
		  	return $this->setContext($value);
			break;
		  case 'host':
		  	return $this->setHost($value);
			break;
		  case 'port':
		  	return $this->setPort($value);
			break;
		  case 'suspend':
		  	return $this->setSuspend($value);
			break;
		  default:
		  	throw new ImuExceptionuException('SessionProperty', $name);
		}
	}

	/**              
	 * Connect.
	 *         
	 * @param void
	 * @return void
	 * @throws \ImuException
	 * @access public
	 */
	public function connect()
	{
		if ($this->_socket != null)
			return;

		ImuTrace::write(2, 'connecting to %s:%d', $this->_host, $this->_port);
		$socket = @fsockopen($this->_host, $this->_port, $errno, $errstr);
		if ($socket === false)
			throw new ImuException('SessionConnect', $this->_host, $this->_port,
				$errstr);
		ImuTrace::write(2, 'connected ok');
		$this->_socket = $socket;
		$this->_stream = new ImuStream($this->_socket);
	}

	/**
	 * Disconnect.
	 * 
	 * @param void
	 * @return void
	 * @access public
	 */
	public function disconnect()
	{
		if ($this->_socket == null)
			return;

		ImuTrace::write(2, 'closing connection');
		@fclose($this->_socket);
		$this->initialise();
	}

	/**              
	 * Login.
	 * 
	 * @param string $login
	 * @param string $password
	 * @param bool $spawn
	 * @return mixed 
	 * @access public
	 */
	public function login($login, $password = null, $spawn = true)
	{
		$request = array();
		$request['login'] = $login;
		$request['password'] = $password;
		$request['spawn'] = $spawn;
		return $this->request($request);
	}

	/**         
	 * Request.
	 * 
	 * @param mixed $request
	 * @return mixed
	 * @throws \ImuException
	 * @access public
	 */
	public function request($request)
	{
		$this->connect();

		if ($this->_close != null)
			$request['close'] = $this->_close;
		if ($this->_context != null)
			$request['context'] = $this->_context;
		if ($this->suspend != null)
			$request['suspend'] = $this->_suspend;

		$this->_stream->put($request);
		$response = $this->_stream->get();
		$type = gettype($response);
		if ($type != 'array')
			throw new ImuException('SessionResponse', $type);

		if (array_key_exists('context', $response))
			$this->_context = $response['context'];
		if (array_key_exists('reconnect', $response))
			$this->_port = $response['reconnect'];

		$disconnect = false;
		if ($this->_close != null)
			$disconnect = $this->_close;
		if ($disconnect)
			$this->disconnect();

		$status = $response['status'];
		if ($status == 'error')
		{
			ImuTrace::write(2, 'server error');

			$id = 'SessionServerError';
			if (array_key_exists('error', $response))
				$id = $response['error'];
			else if (array_key_exists('id', $response))
				$id = $response['id'];

			$e = new ImuException($id);

			if (array_key_exists('args', $response))
				$e->setArgs($response['args']);

			if (array_key_exists('code', $response))
				$e->setCode($response['code']);

			ImuTrace::write(2, 'throwing exception %s', $e->__toString());

			throw $e;
		}

		return $response;
	}

	/**
	 * Initialise.
	 * 
	 * @param void
	 * @return void
	 * @access private
	 */
	private function initialise()
	{
		$this->_close = null;
		$this->_context = null;
		$this->_host = self::$_defaultHost;
		$this->_port = self::$_defaultPort;
		$this->_socket = null;
		$this->_stream = null;
		$this->_suspend = null;
	}
}
