<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

return [
	'default' => 'pgsql',
	'connections' => [
		'pgsql' => [
			'driver'   => 'pgsql',
			'host'     => 'localhost',
			'port'     => 5432,
			'database' => 'moments',
			'username' => 'postgres',
			'password' => 'a123456',
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
			'sslmode'  => 'prefer',
		],
	]

];
