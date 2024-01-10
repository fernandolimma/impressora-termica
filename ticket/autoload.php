<?php
/**
 * Usuários que não possuem 'composer' para gerenciar dependências, incluam este
 * arquivo para fornecer carregamento automático das classes nesta biblioteca.
 */
spl_autoload_register ( function ($class) {
	/*
	 * PSR-4 autoloader, based on PHP Framework Interop Group snippet (Under MIT License.)
	 * https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
	 */
	$prefix = "Mike42\\";
	$base_dir = __DIR__ . "/src/Mike42/";
	
	/* Continuar apenas para classes neste namespace */
	$len = strlen ( $prefix );
	if (strncmp ( $prefix, $class, $len ) !== 0) {
		return;
	}
	
	/* Exigir o arquivo se ele existir */
	$relative_class = substr ( $class, $len );
	$file = $base_dir . str_replace ( '\\', '/', $relative_class ) . '.php';
	if (file_exists ( $file )) {
		require $file;
	}
} );
