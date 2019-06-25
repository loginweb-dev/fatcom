-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2019 a las 22:02:56
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fatcom2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', 'nn', '2019-05-23 18:36:38', '2019-05-23 18:36:38', NULL),
(8, 'Comidas', NULL, '2019-06-19 19:52:14', '2019-06-19 19:52:14', NULL),
(9, 'Bebidas', NULL, '2019-06-19 19:53:44', '2019-06-19 19:53:44', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Category 1', 'category-1', '2019-05-14 02:44:34', '2019-05-14 02:44:34'),
(2, NULL, 1, 'Category 2', 'category-2', '2019-05-14 02:44:34', '2019-05-14 02:44:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `razon_social`, `nit`, `movil`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sin nombre', '00000000', NULL, NULL, NULL, NULL, NULL),
(6, 'Cliente prueba', '123456', NULL, 2, '2019-06-20 18:16:48', '2019-06-20 18:20:29', NULL),
(7, 'Jose Mendez', '654321', NULL, NULL, '2019-06-20 19:17:04', '2019-06-20 19:17:04', NULL),
(8, 'Admin', NULL, NULL, 1, '2019-06-20 22:01:34', '2019-06-20 22:01:34', NULL),
(9, 'Cliente 3', NULL, NULL, 8, '2019-06-21 01:01:31', '2019-06-21 01:01:31', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `nombre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', '2019-05-23 18:38:52', '2019-05-23 18:38:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` date DEFAULT NULL,
  `nit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_factura` int(11) DEFAULT NULL,
  `nro_dui` int(11) DEFAULT NULL,
  `nro_autorizacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `importe_compra` decimal(10,2) DEFAULT NULL,
  `monto_exento` decimal(10,2) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `importe_base` decimal(10,2) DEFAULT NULL,
  `credito_fiscal` decimal(10,2) DEFAULT NULL,
  `codigo_control` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_compra` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `compra_producto` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `fecha`, `nit`, `razon_social`, `nro_factura`, `nro_dui`, `nro_autorizacion`, `importe_compra`, `monto_exento`, `sub_total`, `descuento`, `importe_base`, `credito_fiscal`, `codigo_control`, `tipo_compra`, `compra_producto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2019-06-18', '70', 'Mario Nosa', NULL, NULL, NULL, NULL, NULL, '70.00', NULL, '70.00', NULL, NULL, NULL, 1, '2019-06-19 02:24:06', '2019-06-19 02:24:06', NULL),
(3, '2019-06-18', '12345', 'SIN NOMBRE', 1234, NULL, '272401900228813', '830.00', '0.00', '830.00', '0.00', '830.00', '107.90', 'AC-45-DF-3A', '1', 1, '2019-06-19 02:26:35', '2019-06-19 02:26:35', NULL),
(4, '2019-06-18', '12345', 'SIN NOMBRE', 1234, NULL, '272401900228813', '830.00', '0.00', '830.00', '0.00', '830.00', '107.90', 'AC-45-DF-3A', '1', 1, '2019-06-19 02:32:36', '2019-06-19 02:32:36', NULL),
(5, '2019-06-18', '12345', 'SIN NOMBRE', 2345, NULL, '272401900228813444', '300.00', '0.00', '300.00', '0.00', '300.00', '39.00', 'AB-45-5F-23', '1', NULL, '2019-06-19 02:40:13', '2019-06-19 02:40:13', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras_detalles`
--

CREATE TABLE `compras_detalles` (
  `id` int(10) UNSIGNED NOT NULL,
  `compra_id` int(10) UNSIGNED DEFAULT NULL,
  `producto_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras_detalles`
--

INSERT INTO `compras_detalles` (`id`, `compra_id`, `producto_id`, `precio`, `cantidad`, `created_at`, `updated_at`) VALUES
(1, 4, '5', '400.00', '2.00', '2019-06-19 02:32:36', '2019-06-19 02:32:36'),
(2, 4, '6', '30.00', '1.00', '2019-06-19 02:32:36', '2019-06-19 02:32:36'),
(3, 5, 'Compra de mercadería', '300.00', '1.00', '2019-06-19 02:40:13', '2019-06-19 02:40:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costo_envios`
--

CREATE TABLE `costo_envios` (
  `id` int(10) UNSIGNED NOT NULL,
  `departamento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `tiempo_estimado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `costo_envios`
--

INSERT INTO `costo_envios` (`id`, `departamento`, `localidad`, `precio`, `tiempo_estimado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'beni', 'Santísima Trinidad', '0.00', '1 día', '2019-05-24 02:04:43', '2019-05-24 02:05:36', NULL),
(2, 'beni', 'San Ignacio', '30.00', '1 día', '2019-05-24 02:07:02', '2019-05-24 02:07:02', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(2, 1, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(3, 1, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 3),
(4, 1, 'password', 'password', 'Password', 1, 0, 0, 1, 1, 0, '{}', 4),
(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, '{}', 5),
(6, 1, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 6),
(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 1, 1, 0, 0, 0, '{}', 7),
(8, 1, 'avatar', 'image', 'Avatar', 0, 1, 1, 1, 1, 1, '{}', 8),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":\"0\",\"taggable\":\"0\"}', 10),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', 11),
(11, 1, 'settings', 'hidden', 'Settings', 0, 0, 0, 0, 0, 0, '{}', 12),
(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(16, 3, 'id', 'number', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(17, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 3),
(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 4),
(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, '{}', 5),
(21, 1, 'role_id', 'text', 'Role', 0, 1, 1, 1, 1, 1, '{}', 9),
(22, 4, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(23, 4, 'parent_id', 'select_dropdown', 'Parent', 0, 0, 1, 1, 1, 1, '{\"default\":\"\",\"null\":\"\",\"options\":{\"\":\"-- None --\"},\"relationship\":{\"key\":\"id\",\"label\":\"name\"}}', 2),
(24, 4, 'order', 'text', 'Order', 1, 1, 1, 1, 1, 1, '{\"default\":1}', 3),
(25, 4, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 4),
(26, 4, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 5),
(27, 4, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, NULL, 6),
(28, 4, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(29, 5, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(30, 5, 'author_id', 'text', 'Author', 1, 0, 1, 1, 0, 1, NULL, 2),
(31, 5, 'category_id', 'text', 'Category', 1, 0, 1, 1, 1, 0, NULL, 3),
(32, 5, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, NULL, 4),
(33, 5, 'excerpt', 'text_area', 'Excerpt', 1, 0, 1, 1, 1, 1, NULL, 5),
(34, 5, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, NULL, 6),
(35, 5, 'image', 'image', 'Post Image', 0, 1, 1, 1, 1, 1, '{\"resize\":{\"width\":\"1000\",\"height\":\"null\"},\"quality\":\"70%\",\"upsize\":true,\"thumbnails\":[{\"name\":\"medium\",\"scale\":\"50%\"},{\"name\":\"small\",\"scale\":\"25%\"},{\"name\":\"cropped\",\"crop\":{\"width\":\"300\",\"height\":\"250\"}}]}', 7),
(36, 5, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:posts,slug\"}}', 8),
(37, 5, 'meta_description', 'text_area', 'Meta Description', 1, 0, 1, 1, 1, 1, NULL, 9),
(38, 5, 'meta_keywords', 'text_area', 'Meta Keywords', 1, 0, 1, 1, 1, 1, NULL, 10),
(39, 5, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"DRAFT\",\"options\":{\"PUBLISHED\":\"published\",\"DRAFT\":\"draft\",\"PENDING\":\"pending\"}}', 11),
(40, 5, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 12),
(41, 5, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 13),
(42, 5, 'seo_title', 'text', 'SEO Title', 0, 1, 1, 1, 1, 1, NULL, 14),
(43, 5, 'featured', 'checkbox', 'Featured', 1, 1, 1, 1, 1, 1, NULL, 15),
(44, 6, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(45, 6, 'author_id', 'text', 'Author', 1, 0, 0, 0, 0, 0, NULL, 2),
(46, 6, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, NULL, 3),
(47, 6, 'excerpt', 'text_area', 'Excerpt', 1, 0, 1, 1, 1, 1, NULL, 4),
(48, 6, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, NULL, 5),
(49, 6, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\"},\"validation\":{\"rule\":\"unique:pages,slug\"}}', 6),
(50, 6, 'meta_description', 'text', 'Meta Description', 1, 0, 1, 1, 1, 1, NULL, 7),
(51, 6, 'meta_keywords', 'text', 'Meta Keywords', 1, 0, 1, 1, 1, 1, NULL, 8),
(52, 6, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"INACTIVE\",\"options\":{\"INACTIVE\":\"INACTIVE\",\"ACTIVE\":\"ACTIVE\"}}', 9),
(53, 6, 'created_at', 'timestamp', 'Created At', 1, 1, 1, 0, 0, 0, NULL, 10),
(54, 6, 'updated_at', 'timestamp', 'Updated At', 1, 0, 0, 0, 0, 0, NULL, 11),
(55, 6, 'image', 'image', 'Page Image', 0, 1, 1, 1, 1, 1, NULL, 12),
(56, 11, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(57, 11, 'key', 'text', 'Clave', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(58, 11, 'table_name', 'text', 'Nombre de la tabla', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 3),
(59, 11, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 4),
(60, 11, 'updated_at', 'timestamp', 'Editado', 0, 0, 0, 0, 0, 0, '{}', 5),
(79, 15, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(80, 15, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(81, 15, 'descripcion', 'text_area', 'Descripción', 0, 1, 1, 1, 1, 1, '{}', 3),
(82, 15, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 4),
(83, 15, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 5),
(84, 15, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 6),
(85, 16, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(86, 16, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 3),
(87, 16, 'descripcion', 'text_area', 'Descripción', 0, 1, 1, 1, 1, 1, '{}', 5),
(88, 16, 'categoria_id', 'text', 'Creado', 0, 1, 1, 1, 1, 1, '{}', 4),
(89, 16, 'created_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 6),
(90, 16, 'updated_at', 'timestamp', 'Updated At', 0, 1, 1, 0, 0, 0, '{}', 7),
(91, 16, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 8),
(92, 16, 'subcategoria_belongsto_categoria_relationship', 'relationship', 'categorias', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Categoria\",\"table\":\"categorias\",\"type\":\"belongsTo\",\"column\":\"categoria_id\",\"key\":\"id\",\"label\":\"nombre\",\"pivot_table\":\"categorias\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(93, 17, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(94, 17, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(95, 17, 'abreviacion', 'text', 'Abreviación', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:5\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 3),
(96, 17, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 4),
(97, 17, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 5),
(98, 17, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 6),
(99, 18, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(100, 18, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(101, 18, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 3),
(102, 18, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 4),
(103, 18, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 5),
(104, 19, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(106, 19, 'tamanio_id', 'text', 'Tamanio Id', 0, 1, 1, 1, 1, 1, '{}', 4),
(107, 19, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 5),
(108, 19, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 6),
(109, 19, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 7),
(110, 20, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(111, 20, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(112, 20, 'descripcion', 'text_area', 'Descripción', 0, 1, 1, 1, 1, 1, '{}', 3),
(113, 20, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 4),
(114, 20, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 5),
(115, 20, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 6),
(116, 19, 'talla_belongsto_tamanio_relationship', 'relationship', 'tamaño', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Tamanio\",\"table\":\"tamanios\",\"type\":\"belongsTo\",\"column\":\"tamanio_id\",\"key\":\"id\",\"label\":\"nombre\",\"pivot_table\":\"categorias\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(117, 21, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(118, 21, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(119, 21, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 3),
(120, 21, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 4),
(121, 21, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 5),
(122, 22, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(123, 22, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(124, 22, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 1, 0, 1, '{}', 3),
(125, 22, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 4),
(126, 22, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 5),
(127, 23, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(128, 23, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(129, 23, 'descripcion', 'text_area', 'Descripción', 0, 1, 1, 1, 1, 1, '{}', 3),
(130, 23, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 4),
(131, 23, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 5),
(132, 23, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 6),
(139, 25, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(140, 25, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:20\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(141, 25, 'abreviacion', 'text', 'Abreviación', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:5\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 3),
(142, 25, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 4),
(143, 25, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 5),
(144, 25, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 6),
(145, 26, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(146, 26, 'departamento', 'select_dropdown', 'Departamento', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"options\":{\"beni\":\"Beni\",\"chuquisaca\":\"Chuquisaca\",\"cochabamba\":\"Cochabamba\",\"la paz\":\"La paz\",\"oruro\":\"Oruro\",\"pando\":\"Pando\",\"potosi\":\"Potos\\u00ed\",\"santa cruz\":\"Santa cruz\",\"tarija\":\"Tarija\"}}', 2),
(147, 26, 'localidad', 'text', 'Localidad', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 3),
(148, 26, 'precio', 'number', 'Precio', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:10\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 4),
(149, 26, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 6),
(150, 26, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 7),
(151, 26, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 8),
(152, 26, 'tiempo_estimado', 'text', 'Tiempo estimado de llegada', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 5),
(153, 19, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{}', 2),
(154, 1, 'email_verified_at', 'timestamp', 'Email Verified At', 0, 1, 1, 1, 1, 1, '{}', 6),
(155, 27, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(156, 27, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{}', 2),
(157, 27, 'unidad_id', 'text', 'Unidad Id', 0, 1, 1, 1, 1, 1, '{}', 3),
(158, 27, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 4),
(159, 27, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 5),
(160, 27, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 6),
(161, 27, 'insumo_belongsto_unidade_relationship', 'relationship', 'unidades', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Unidade\",\"table\":\"unidades\",\"type\":\"belongsTo\",\"column\":\"unidad_id\",\"key\":\"id\",\"label\":\"nombre\",\"pivot_table\":\"categorias\",\"pivot\":\"0\",\"taggable\":null}', 7),
(162, 29, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(163, 29, 'nit', 'text', 'Nit', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:20\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(164, 29, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 3),
(165, 29, 'telefono', 'text', 'Telefono', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"}}', 4),
(166, 29, 'movil', 'text', 'Movil', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 5),
(167, 29, 'mail', 'text', 'Mail', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 6),
(168, 29, 'direccion', 'text_area', 'Dirección', 0, 1, 1, 1, 1, 1, '{}', 7),
(169, 29, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 8),
(170, 29, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 9),
(171, 29, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 10),
(172, 30, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(174, 30, 'nit', 'text', 'NIT', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 3),
(175, 30, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 6),
(176, 30, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 8),
(177, 30, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 9),
(178, 30, 'movil', 'text', 'Móvil', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 4),
(179, 30, 'cliente_belongsto_user_relationship', 'relationship', 'Email', 0, 1, 1, 0, 0, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"email\",\"pivot_table\":\"categorias\",\"pivot\":\"0\",\"taggable\":\"0\"}', 5),
(180, 30, 'user_id', 'text', 'User Id', 0, 0, 0, 0, 0, 0, '{}', 7),
(181, 30, 'razon_social', 'text', 'Nombre o razón social', 0, 1, 1, 1, 1, 1, '{}', 2),
(190, 32, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(191, 32, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 3),
(192, 32, 'descripcion', 'text_area', 'Descripción', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"El campo :attribute es requerido.\"}}}', 4),
(193, 32, 'icono', 'image', 'Icono', 0, 1, 1, 1, 1, 1, '{}', 2),
(194, 32, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 6),
(195, 32, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 7),
(196, 32, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 8),
(197, 32, 'estado', 'checkbox', 'Estado', 0, 1, 1, 1, 1, 1, '{\"on\":\"Activo\",\"off\":\"Inactivo\",\"checked\":\"true\"}', 5),
(198, 33, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(199, 33, 'nombre', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 2),
(200, 33, 'direccion', 'text_area', 'Dirección', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"El campo :attribute es requerido.\"}}}', 4),
(201, 33, 'movil', 'text', 'Movil', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|max:50\",\"messages\":{\"required\":\"El campo :attribute es requerido.\",\"max\":\"El campo :attribute debe tener un maximo de :max caracteres.\"}}}', 3),
(202, 33, 'foto', 'image', 'Foto', 0, 1, 1, 1, 1, 1, '{}', 5),
(203, 33, 'created_at', 'timestamp', 'Creado', 0, 1, 1, 0, 0, 0, '{}', 8),
(204, 33, 'updated_at', 'timestamp', 'Editado', 0, 1, 1, 0, 0, 0, '{}', 9),
(205, 33, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 10),
(206, 33, 'repartidore_belongsto_user_relationship', 'relationship', 'Usuario', 0, 1, 1, 1, 1, 1, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categorias\",\"pivot\":\"0\",\"taggable\":\"0\"}', 7),
(207, 33, 'user_id', 'text', 'User Id', 0, 1, 1, 1, 1, 1, '{}', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_types`
--

CREATE TABLE `data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint(4) NOT NULL DEFAULT '0',
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"name\",\"order_direction\":\"desc\",\"default_search_key\":\"name\",\"scope\":null}', '2019-05-14 02:44:09', '2019-06-05 02:33:54'),
(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2019-05-14 02:44:09', '2019-05-14 02:44:09'),
(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, NULL, NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"name\",\"order_direction\":\"desc\",\"default_search_key\":\"name\",\"scope\":null}', '2019-05-14 02:44:09', '2019-06-05 02:37:09'),
(4, 'categories', 'categories', 'Category', 'Categories', 'voyager-categories', 'TCG\\Voyager\\Models\\Category', NULL, '', '', 1, 0, NULL, '2019-05-14 02:44:32', '2019-05-14 02:44:32'),
(5, 'posts', 'posts', 'Post', 'Posts', 'voyager-news', 'TCG\\Voyager\\Models\\Post', 'TCG\\Voyager\\Policies\\PostPolicy', '', '', 1, 0, NULL, '2019-05-14 02:44:34', '2019-05-14 02:44:34'),
(6, 'pages', 'pages', 'Page', 'Pages', 'voyager-file-text', 'TCG\\Voyager\\Models\\Page', NULL, '', '', 1, 0, NULL, '2019-05-14 02:44:37', '2019-05-14 02:44:37'),
(11, 'permissions', 'permissions', 'Permiso', 'Permisos', NULL, 'App\\Permission', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-14 04:22:03', '2019-05-22 20:17:31'),
(15, 'categorias', 'categorias', 'Categoría', 'Categorías', 'voyager-params', 'App\\Categoria', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-18 22:42:50', '2019-05-23 18:41:50'),
(16, 'subcategorias', 'subcategorias', 'Sub categoría', 'Sub categorías', 'voyager-list', 'App\\Subcategoria', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-20 22:06:13', '2019-05-23 18:42:45'),
(17, 'unidades', 'unidades', 'Unidad', 'Unidades', 'voyager-bar-chart', 'App\\Unidade', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-20 22:15:00', '2019-05-23 18:44:31'),
(18, 'marcas', 'marcas', 'Marca', 'Marcas', 'voyager-tag', 'App\\Marca', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-20 22:21:55', '2019-05-20 22:22:52'),
(19, 'tallas', 'tallas', 'Talla', 'Tallas', 'voyager-ticket', 'App\\Talla', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-20 22:26:55', '2019-05-24 20:41:14'),
(20, 'tamanios', 'tamanios', 'Tamaño', 'Tamaños', 'voyager-resize-full', 'App\\Tamanio', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-20 22:28:39', '2019-05-23 18:46:20'),
(21, 'colores', 'colores', 'Color', 'Colores', 'voyager-paint-bucket', 'App\\Colore', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-20 22:35:23', '2019-05-23 18:48:20'),
(22, 'generos', 'generos', 'Genero', 'Generos', 'voyager-params', 'App\\Genero', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-20 22:59:35', '2019-05-20 23:01:12'),
(23, 'usos', 'usos', 'Uso', 'Usos', 'voyager-lightbulb', 'App\\Uso', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-21 01:02:15', '2019-05-23 18:49:05'),
(25, 'monedas', 'monedas', 'Moneda', 'Monedas', 'voyager-dollar', 'App\\Moneda', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-23 02:29:40', '2019-05-23 02:31:44'),
(26, 'costo_envios', 'costo-envios', 'Costo de Envío', 'Costo de Envíos', 'voyager-external', 'App\\CostoEnvio', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-05-24 01:57:25', '2019-05-24 02:03:57'),
(27, 'insumos', 'insumos', 'Insumo', 'Insumos', 'voyager-params', 'App\\Insumo', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2019-06-15 01:19:56', '2019-06-15 01:19:56'),
(29, 'proveedores', 'proveedores', 'Proveedor', 'Proveedores', 'voyager-people', 'App\\Proveedore', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-06-19 01:31:59', '2019-06-19 01:39:03'),
(30, 'clientes', 'clientes', 'Cliente', 'Clientes', 'voyager-people', 'App\\Cliente', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-06-19 19:11:59', '2019-06-20 18:19:58'),
(32, 'pasarela_pagos', 'pasarela-pagos', 'Pasarelas de  Pago', 'Pasarela de Pagos', 'voyager-logbook', 'App\\PasarelaPago', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-06-21 02:23:34', '2019-06-21 02:54:16'),
(33, 'repartidores', 'repartidores', 'Repartidor', 'Repartidores', 'voyager-truck', 'App\\Repartidore', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-06-22 19:48:23', '2019-06-23 00:07:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depositos`
--

CREATE TABLE `depositos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `sucursal_id` int(11) DEFAULT NULL,
  `inventario` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `depositos`
--

INSERT INTO `depositos` (`id`, `nombre`, `direccion`, `sucursal_id`, `inventario`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Deposito - Casa Matriz', 'Calle 6 de agostos', 3, 1, '2019-05-18 21:34:13', '2019-05-22 19:17:49', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deposito_productos`
--

CREATE TABLE `deposito_productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `deposito_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_inicial` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ecommerce_productos`
--

CREATE TABLE `ecommerce_productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `escasez` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio_envio` decimal(10,2) DEFAULT NULL,
  `precio_envio_rapido` decimal(10,2) DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ecommerce_productos`
--

INSERT INTO `ecommerce_productos` (`id`, `producto_id`, `escasez`, `precio_envio`, `precio_envio_rapido`, `tags`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, '2019-06-19 20:05:06', '2019-06-19 20:05:06', NULL),
(2, 2, NULL, NULL, NULL, NULL, '2019-06-19 20:05:06', '2019-06-19 20:05:06', NULL),
(3, 3, NULL, NULL, NULL, NULL, '2019-06-19 20:05:06', '2019-06-19 20:05:06', NULL),
(4, 4, NULL, NULL, NULL, NULL, '2019-06-19 21:32:30', '2019-06-19 21:32:30', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', '2019-05-23 18:39:10', '2019-05-23 18:39:10', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ie_asientos`
--

CREATE TABLE `ie_asientos` (
  `id` int(10) UNSIGNED NOT NULL,
  `concepto` text COLLATE utf8mb4_unicode_ci,
  `monto` decimal(10,2) DEFAULT NULL,
  `tipo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `caja_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `compra_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ie_asientos`
--

INSERT INTO `ie_asientos` (`id`, `concepto`, `monto`, `tipo`, `fecha`, `hora`, `user_id`, `caja_id`, `created_at`, `updated_at`, `deleted_at`, `venta_id`, `compra_id`) VALUES
(1, 'nn', '100.00', 'ingreso', '2019-06-14', '19:40:00', 1, 1, '2019-06-14 23:40:21', '2019-06-14 23:40:21', '2019-06-14 23:43:16', NULL, NULL),
(2, 'nn', '100.00', 'ingreso', '2019-06-14', '19:52:00', 1, 1, '2019-06-14 23:52:39', '2019-06-14 23:52:39', NULL, NULL, NULL),
(3, 'Gastos varios', '50.00', 'egreso', '2019-06-19', '17:39:00', 1, 1, '2019-06-19 21:40:28', '2019-06-19 21:40:28', NULL, NULL, NULL),
(4, 'Venta de mercadería', NULL, 'ingreso', '2019-06-19', '22:28:51', 1, 2, '2019-06-20 02:28:51', '2019-06-20 02:28:51', NULL, 10, NULL),
(5, 'Venta de mercadería', NULL, 'ingreso', '2019-06-19', '22:29:36', 1, 2, '2019-06-20 02:29:36', '2019-06-20 02:29:36', NULL, 11, NULL),
(6, 'Venta de mercadería', NULL, 'ingreso', '2019-06-19', '22:29:56', 1, 2, '2019-06-20 02:29:56', '2019-06-20 02:29:56', NULL, 12, NULL),
(7, 'Venta de mercadería', NULL, 'ingreso', '2019-06-19', '22:30:14', 1, 2, '2019-06-20 02:30:14', '2019-06-20 02:30:14', NULL, 13, NULL),
(8, 'Venta de mercadería', NULL, 'ingreso', '2019-06-19', '22:30:50', 1, 2, '2019-06-20 02:30:50', '2019-06-20 02:30:50', NULL, 14, NULL),
(9, 'Venta de mercadería', NULL, 'ingreso', '2019-06-19', '23:02:21', 1, 2, '2019-06-20 03:02:21', '2019-06-20 03:02:21', NULL, 19, NULL),
(10, 'Venta de mercadería', NULL, 'ingreso', '2019-06-19', '23:05:36', 1, 2, '2019-06-20 03:05:36', '2019-06-20 03:05:36', NULL, 21, NULL),
(11, 'Venta de mercadería', NULL, 'ingreso', '2019-06-19', '23:24:43', 1, 2, '2019-06-20 03:24:43', '2019-06-20 03:24:43', NULL, 23, NULL),
(12, 'Venta de mercadería', NULL, 'ingreso', '2019-06-19', '23:26:23', 1, 2, '2019-06-20 03:26:23', '2019-06-20 03:26:23', NULL, 24, NULL),
(13, 'Venta de mercadería', NULL, 'ingreso', '2019-06-20', '15:17:04', 1, 2, '2019-06-20 19:17:04', '2019-06-20 19:17:04', NULL, 29, NULL),
(14, 'Venta de mercadería', '12.00', 'ingreso', '2019-06-20', '15:20:03', 1, 2, '2019-06-20 19:20:03', '2019-06-20 19:20:03', NULL, 30, NULL),
(15, 'Venta de mercadería', '152.00', 'ingreso', '2019-06-20', '15:42:59', 1, 2, '2019-06-20 19:42:59', '2019-06-20 19:42:59', NULL, 31, NULL),
(16, 'Venta realizadas', '32.00', 'ingreso', '2019-06-20', '18:26:53', 1, 3, '2019-06-20 22:26:53', '2019-06-20 22:26:53', NULL, 41, NULL),
(17, 'Venta realizadas', '52.00', 'ingreso', '2019-06-20', '18:28:06', 1, 3, '2019-06-20 22:28:06', '2019-06-20 22:28:06', NULL, 42, NULL),
(18, 'Venta realizadas', '35.00', 'ingreso', '2019-06-20', '18:30:51', 1, 3, '2019-06-20 22:30:51', '2019-06-20 22:30:51', NULL, 43, NULL),
(19, 'Venta realizadas', '35.00', 'ingreso', '2019-06-20', '18:30:52', 1, 3, '2019-06-20 22:30:52', '2019-06-20 22:30:52', NULL, 44, NULL),
(20, 'Venta realizadas', '47.00', 'ingreso', '2019-06-20', '18:34:41', 1, 3, '2019-06-20 22:34:41', '2019-06-20 22:34:41', NULL, 45, NULL),
(21, 'Venta realizadas', '35.00', 'ingreso', '2019-06-20', '18:36:30', 1, 3, '2019-06-20 22:36:30', '2019-06-20 22:36:30', NULL, 46, NULL),
(22, 'Venta realizadas', '12.00', 'ingreso', '2019-06-20', '18:38:21', 1, 3, '2019-06-20 22:38:21', '2019-06-20 22:38:21', NULL, 48, NULL),
(23, 'Venta realizadas', '47.00', 'ingreso', '2019-06-20', '18:39:49', 1, 3, '2019-06-20 22:39:49', '2019-06-20 22:39:49', NULL, 49, NULL),
(24, 'Venta realizadas', '40.00', 'ingreso', '2019-06-20', '18:41:57', 1, 3, '2019-06-20 22:41:57', '2019-06-20 22:41:57', NULL, 50, NULL),
(25, 'Venta realizadas', '40.00', 'ingreso', '2019-06-20', '20:51:21', 1, 3, '2019-06-21 00:51:21', '2019-06-21 00:51:21', NULL, 51, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ie_cajas`
--

CREATE TABLE `ie_cajas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `fecha_apertura` date DEFAULT NULL,
  `hora_apertura` time DEFAULT NULL,
  `fecha_cierre` date DEFAULT NULL,
  `hora_cierre` time DEFAULT NULL,
  `monto_inicial` decimal(10,2) DEFAULT NULL,
  `monto_final` decimal(10,2) DEFAULT NULL,
  `total_ingresos` decimal(10,2) DEFAULT NULL,
  `total_egresos` decimal(10,2) DEFAULT NULL,
  `abierta` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ie_cajas`
--

INSERT INTO `ie_cajas` (`id`, `nombre`, `observaciones`, `fecha_apertura`, `hora_apertura`, `fecha_cierre`, `hora_cierre`, `monto_inicial`, `monto_final`, `total_ingresos`, `total_egresos`, `abierta`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Caja turno noche', NULL, '2019-06-14', '16:48:00', '2019-06-19', '17:41:00', '100.00', '150.00', '100.00', '50.00', 0, 1, '2019-06-14 20:50:54', '2019-06-19 21:41:18', NULL),
(2, 'Caja principal', 'nn', '2019-06-19', '17:41:00', '2019-06-20', '15:44:00', '100.00', '252.00', '152.00', '0.00', 0, 1, '2019-06-19 21:42:15', '2019-06-20 19:44:18', NULL),
(3, 'Caja principal', NULL, '2019-06-20', '18:23:00', NULL, NULL, '100.00', '475.00', '375.00', '0.00', 1, 1, '2019-06-20 22:23:52', '2019-06-20 22:23:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

CREATE TABLE `insumos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `insumos`
--

INSERT INTO `insumos` (`id`, `nombre`, `unidad_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Harina', 2, '2019-06-15 02:21:59', '2019-06-15 02:21:59', NULL),
(2, 'Leche', 3, '2019-06-15 02:22:14', '2019-06-15 02:22:14', NULL),
(3, 'Huevos', 4, '2019-06-15 02:22:28', '2019-06-15 02:22:28', NULL),
(4, 'Carne', 2, '2019-06-15 02:22:40', '2019-06-15 02:22:40', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', '2019-05-23 18:37:52', '2019-05-23 18:37:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2019-05-14 02:44:11', '2019-05-14 02:44:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Inicio', '', '_self', 'voyager-dashboard', '#000000', NULL, 1, '2019-05-14 02:44:12', '2019-05-14 00:32:34', 'voyager.dashboard', 'null'),
(2, 1, 'Media', '', '_self', 'voyager-images', NULL, 5, 5, '2019-05-14 02:44:12', '2019-05-14 00:27:11', 'voyager.media.index', NULL),
(3, 1, 'Usuarios', '', '_self', 'voyager-people', '#000000', 16, 1, '2019-05-14 02:44:12', '2019-05-14 00:33:34', 'voyager.users.index', 'null'),
(4, 1, 'Roles', '', '_self', 'voyager-tag', '#000000', 16, 2, '2019-05-14 02:44:13', '2019-05-14 00:35:12', 'voyager.roles.index', 'null'),
(5, 1, 'Herramientas', '', '_self', 'voyager-tools', '#000000', NULL, 3, '2019-05-14 02:44:14', '2019-05-14 00:28:04', NULL, ''),
(6, 1, 'Menu Builder', '', '_self', 'voyager-list', NULL, 5, 1, '2019-05-14 02:44:14', '2019-05-14 04:22:40', 'voyager.menus.index', NULL),
(7, 1, 'Database', '', '_self', 'voyager-data', NULL, 5, 2, '2019-05-14 02:44:14', '2019-05-14 04:22:41', 'voyager.database.index', NULL),
(8, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 5, 3, '2019-05-14 02:44:14', '2019-05-14 04:22:41', 'voyager.compass.index', NULL),
(9, 1, 'BREAD', '', '_self', 'voyager-bread', NULL, 5, 4, '2019-05-14 02:44:14', '2019-05-14 04:22:41', 'voyager.bread.index', NULL),
(10, 1, 'Configuración', '', '_self', 'voyager-settings', '#000000', NULL, 5, '2019-05-14 02:44:14', '2019-05-14 00:36:58', 'voyager.settings.index', 'null'),
(11, 1, 'Categories', '', '_self', 'voyager-categories', NULL, 17, 3, '2019-05-14 02:44:33', '2019-05-14 00:28:04', 'voyager.categories.index', NULL),
(12, 1, 'Posts', '', '_self', 'voyager-news', NULL, 17, 1, '2019-05-14 02:44:37', '2019-05-14 00:28:00', 'voyager.posts.index', NULL),
(13, 1, 'Pages', '', '_self', 'voyager-file-text', NULL, 17, 2, '2019-05-14 02:44:38', '2019-05-14 00:28:01', 'voyager.pages.index', NULL),
(14, 1, 'Hooks', '', '_self', 'voyager-hook', NULL, 5, 6, '2019-05-14 02:44:44', '2019-05-14 00:27:11', 'voyager.hooks', NULL),
(15, 1, 'Permisos', '', '_self', 'voyager-certificate', '#000000', 16, 3, '2019-05-14 04:22:05', '2019-05-14 00:34:19', 'voyager.permissions.index', 'null'),
(16, 1, 'Seguridad', '', '_self', 'voyager-lock', '#000000', NULL, 4, '2019-05-14 04:22:31', '2019-05-14 00:36:58', NULL, ''),
(17, 1, 'Ejemplos', '', '_self', 'voyager-laptop', '#000000', NULL, 2, '2019-05-14 00:27:45', '2019-05-14 00:29:02', NULL, ''),
(21, 1, 'Inventario', '', '_self', 'voyager-data', '#000000', NULL, 6, '2019-05-14 02:57:48', '2019-05-15 21:23:24', NULL, ''),
(23, 1, 'Depositos', '', '_self', 'voyager-archive', '#000000', 21, 2, '2019-05-14 02:59:31', '2019-05-18 22:12:38', 'depositos_index', 'null'),
(24, 1, 'Productos', '', '_self', 'voyager-harddrive', '#000000', 21, 3, '2019-05-14 02:59:31', '2019-05-22 23:29:30', 'productos_index', 'null'),
(26, 1, 'Sucursale', '', '_self', 'voyager-home', '#000000', 21, 1, '2019-05-17 02:25:18', '2019-05-18 19:11:04', 'sucursales_index', NULL),
(30, 1, 'Categorias', '', '_self', 'voyager-params', '#000000', 21, 6, '2019-05-18 22:42:51', '2019-05-28 20:40:03', 'voyager.categorias.index', 'null'),
(31, 1, 'Subcategorias', '', '_self', 'voyager-list', '#000000', 21, 7, '2019-05-20 22:06:13', '2019-05-28 20:40:03', 'voyager.subcategorias.index', 'null'),
(32, 1, 'Unidades', '', '_self', 'voyager-bar-chart', '#000000', 49, 6, '2019-05-20 22:15:00', '2019-06-15 01:44:10', 'voyager.unidades.index', 'null'),
(33, 1, 'Marcas', '', '_self', 'voyager-tag', '#000000', 21, 8, '2019-05-20 22:21:55', '2019-06-15 01:44:18', 'voyager.marcas.index', 'null'),
(34, 1, 'Tallas', '', '_self', 'voyager-ticket', '#000000', 49, 3, '2019-05-20 22:26:56', '2019-06-15 01:43:49', 'voyager.tallas.index', 'null'),
(35, 1, 'Tamaños', '', '_self', 'voyager-resize-full', '#000000', 49, 4, '2019-05-20 22:28:40', '2019-06-15 01:43:57', 'voyager.tamanios.index', 'null'),
(36, 1, 'Colores', '', '_self', 'voyager-paint-bucket', '#000000', 49, 2, '2019-05-20 22:35:24', '2019-06-15 01:43:44', 'voyager.colores.index', 'null'),
(37, 1, 'Generos', '', '_self', 'voyager-params', '#000000', 49, 7, '2019-05-20 22:59:35', '2019-06-15 01:44:19', 'voyager.generos.index', 'null'),
(38, 1, 'Usos', '', '_self', 'voyager-lightbulb', '#000000', 49, 5, '2019-05-21 01:02:16', '2019-06-15 01:44:03', 'voyager.usos.index', 'null'),
(40, 1, 'Monedas', '', '_self', 'voyager-dollar', '#000000', 49, 1, '2019-05-23 02:29:41', '2019-06-15 01:43:38', 'voyager.monedas.index', 'null'),
(41, 1, 'Costo de Envíos', '', '_self', 'voyager-external', NULL, 21, 9, '2019-05-24 01:57:25', '2019-06-15 01:44:19', 'voyager.costo-envios.index', NULL),
(42, 1, 'Ofertas', '', '_self', 'voyager-certificate', '#000000', 21, 4, '2019-05-27 21:36:04', '2019-05-27 21:37:45', 'ofertas_index', 'null'),
(43, 1, 'E-commerce', '', '_self', 'voyager-basket', '#000000', 21, 5, '2019-05-28 20:39:06', '2019-05-28 20:40:02', 'ecommerce_index', NULL),
(44, 1, 'Ingresos y egresos', '', '_self', 'voyager-book', '#000000', NULL, 7, '2019-06-14 20:32:04', '2019-06-14 20:38:19', NULL, ''),
(45, 1, 'Cajas', '', '_self', 'voyager-treasure', '#000000', 44, 1, '2019-06-14 20:32:26', '2019-06-14 20:39:26', 'cajas_index', 'null'),
(46, 1, 'Registros', '', '_self', 'voyager-book', '#000000', 44, 2, '2019-06-14 23:08:23', '2019-06-14 23:08:33', 'asientos_index', NULL),
(47, 1, 'Insumos', '', '_self', 'voyager-params', NULL, 48, 2, '2019-06-15 01:19:57', '2019-06-18 22:26:15', 'voyager.insumos.index', NULL),
(48, 1, 'Módulo de Compras', '', '_self', 'voyager-shop', '#000000', NULL, 8, '2019-06-15 01:34:23', '2019-06-18 22:23:05', NULL, ''),
(49, 1, 'Parametros', '', '_self', 'voyager-params', '#000000', NULL, 10, '2019-06-15 01:43:08', '2019-06-19 19:07:08', NULL, ''),
(50, 1, 'Compras', '', '_self', 'voyager-buy', '#000000', 48, 1, '2019-06-18 22:26:01', '2019-06-18 22:27:15', 'compras_index', 'null'),
(51, 1, 'Proveedores', '', '_self', 'voyager-people', '#000000', 48, 3, '2019-06-19 01:32:00', '2019-06-19 01:37:04', 'voyager.proveedores.index', 'null'),
(52, 1, 'Módulo de Ventas', '', '_self', 'voyager-basket', '#000000', NULL, 9, '2019-06-19 19:06:09', '2019-06-19 19:07:13', NULL, ''),
(53, 1, 'Ventas', '', '_self', 'voyager-book', '#000000', 52, 1, '2019-06-19 19:06:50', '2019-06-19 19:06:58', 'ventas_index', NULL),
(54, 1, 'Clientes', '', '_self', 'voyager-people', NULL, 52, 2, '2019-06-19 19:12:00', '2019-06-19 19:12:22', 'voyager.clientes.index', NULL),
(56, 1, 'Pasarelas de Pagos', '', '_self', 'voyager-wallet', '#000000', NULL, 11, '2019-06-21 02:23:35', '2019-06-22 19:55:22', 'voyager.pasarela-pagos.index', 'null'),
(57, 1, 'Repartidores', '', '_self', 'voyager-people', '#000000', NULL, 12, '2019-06-22 19:48:24', '2019-06-23 00:12:09', 'voyager.repartidores.index', 'null'),
(58, 1, 'Delivery', '', '_self', 'voyager-truck', '#000000', NULL, 13, '2019-06-23 00:11:32', '2019-06-23 00:11:32', 'delivery_index', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_01_000000_add_voyager_user_fields', 1),
(4, '2016_01_01_000000_create_data_types_table', 1),
(5, '2016_05_19_173453_create_menu_table', 1),
(6, '2016_10_21_190000_create_roles_table', 1),
(7, '2016_10_21_190000_create_settings_table', 1),
(8, '2016_11_30_135954_create_permission_table', 1),
(9, '2016_11_30_141208_create_permission_role_table', 1),
(10, '2016_12_26_201236_data_types__add__server_side', 1),
(11, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(12, '2017_01_14_005015_create_translations_table', 1),
(13, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
(14, '2017_03_06_000000_add_controller_to_data_types_table', 1),
(15, '2017_04_21_000000_add_order_to_data_rows_table', 1),
(16, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
(17, '2017_08_05_000000_add_group_to_settings_table', 1),
(18, '2017_11_26_013050_add_user_role_relationship', 1),
(19, '2017_11_26_015000_create_user_roles_table', 1),
(20, '2018_03_11_000000_add_user_settings', 1),
(21, '2018_03_14_000000_add_details_to_data_types_table', 1),
(22, '2018_03_16_000000_make_settings_value_nullable', 1),
(23, '2016_01_01_000000_create_pages_table', 2),
(24, '2016_01_01_000000_create_posts_table', 2),
(25, '2016_02_15_204651_create_categories_table', 2),
(26, '2017_04_11_000000_alter_post_nullable_fields_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abreviacion` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`id`, `nombre`, `abreviacion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', 'df', '2019-05-23 18:40:23', '2019-05-23 18:40:23', NULL),
(2, 'Bolivianos', 'Bs.', '2019-05-23 21:54:28', '2019-05-23 21:54:28', NULL),
(3, 'Dolares', '$us.', '2019-05-23 21:54:43', '2019-05-23 21:54:43', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detalle` text COLLATE utf8mb4_unicode_ci,
  `inicio` timestamp NULL DEFAULT NULL,
  `fin` timestamp NULL DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`id`, `nombre`, `detalle`, `inicio`, `fin`, `imagen`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Generico', NULL, '2019-06-19 04:00:00', NULL, NULL, '2019-06-19 21:31:20', '2019-06-19 21:31:20', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas_detalles`
--

CREATE TABLE `ofertas_detalles` (
  `id` int(10) UNSIGNED NOT NULL,
  `oferta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `tipo_descuento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ofertas_detalles`
--

INSERT INTO `ofertas_detalles` (`id`, `oferta_id`, `producto_id`, `tipo_descuento`, `monto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'porcentaje', '10.00', '2019-06-19 21:31:21', '2019-06-19 21:31:21', NULL),
(2, 1, 2, 'monto', '5.00', '2019-06-19 21:31:21', '2019-06-19 21:31:21', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pages`
--

INSERT INTO `pages` (`id`, `author_id`, `title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'Hello World', 'Hang the jib grog grog blossom grapple dance the hempen jig gangway pressgang bilge rat to go on account lugger. Nelsons folly gabion line draught scallywag fire ship gaff fluke fathom case shot. Sea Legs bilge rat sloop matey gabion long clothes run a shot across the bow Gold Road cog league.', '<p>Hello World. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', 'pages/page1.jpg', 'hello-world', 'Yar Meta Description', 'Keyword1, Keyword2', 'ACTIVE', '2019-05-14 02:44:39', '2019-05-14 02:44:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasarela_pagos`
--

CREATE TABLE `pasarela_pagos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pasarela_pagos`
--

INSERT INTO `pasarela_pagos` (`id`, `nombre`, `descripcion`, `icono`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pago contra Entrega!', 'Usted paga por la mercancía, a la entrega', 'pasarela-pagos\\June2019\\Bdjin2EnljRe7MuKdeq1.jpg', 1, '2019-06-21 02:29:56', '2019-06-21 02:29:56', NULL),
(2, 'Deposito bancario', 'Cuenta del Banco Unión N° 1234567890', 'pasarela-pagos\\June2019\\XHQzPzvY3BOkbfvogcrb.jpg', 0, '2019-06-21 02:32:08', '2019-06-21 02:54:35', NULL),
(3, 'Deposito bancario', 'Cuenta del Banco Mercantil Santa Cruz N° 0987654321', 'pasarela-pagos\\June2019\\9nexB7e4En89c9ecxDh5.jpg', 0, '2019-06-21 02:33:21', '2019-06-21 02:54:25', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
(1, 'browse_admin', NULL, '2019-05-14 02:44:14', '2019-05-14 02:44:14'),
(2, 'browse_bread', NULL, '2019-05-14 02:44:14', '2019-05-14 02:44:14'),
(3, 'browse_database', NULL, '2019-05-14 02:44:14', '2019-05-14 02:44:14'),
(4, 'browse_media', NULL, '2019-05-14 02:44:14', '2019-05-14 02:44:14'),
(5, 'browse_compass', NULL, '2019-05-14 02:44:14', '2019-05-14 02:44:14'),
(6, 'browse_menus', 'menus', '2019-05-14 02:44:14', '2019-05-14 02:44:14'),
(7, 'read_menus', 'menus', '2019-05-14 02:44:15', '2019-05-14 02:44:15'),
(8, 'edit_menus', 'menus', '2019-05-14 02:44:15', '2019-05-14 02:44:15'),
(9, 'add_menus', 'menus', '2019-05-14 02:44:15', '2019-05-14 02:44:15'),
(10, 'delete_menus', 'menus', '2019-05-14 02:44:15', '2019-05-14 02:44:15'),
(11, 'browse_roles', 'roles', '2019-05-14 02:44:15', '2019-05-14 02:44:15'),
(12, 'read_roles', 'roles', '2019-05-14 02:44:15', '2019-05-14 02:44:15'),
(13, 'edit_roles', 'roles', '2019-05-14 02:44:16', '2019-05-14 02:44:16'),
(14, 'add_roles', 'roles', '2019-05-14 02:44:16', '2019-05-14 02:44:16'),
(15, 'delete_roles', 'roles', '2019-05-14 02:44:16', '2019-05-14 02:44:16'),
(16, 'browse_users', 'users', '2019-05-14 02:44:17', '2019-05-14 02:44:17'),
(17, 'read_users', 'users', '2019-05-14 02:44:17', '2019-05-14 02:44:17'),
(18, 'edit_users', 'users', '2019-05-14 02:44:17', '2019-05-14 02:44:17'),
(19, 'add_users', 'users', '2019-05-14 02:44:17', '2019-05-14 02:44:17'),
(20, 'delete_users', 'users', '2019-05-14 02:44:18', '2019-05-14 02:44:18'),
(21, 'browse_settings', 'settings', '2019-05-14 02:44:18', '2019-05-14 02:44:18'),
(22, 'read_settings', 'settings', '2019-05-14 02:44:18', '2019-05-14 02:44:18'),
(23, 'edit_settings', 'settings', '2019-05-14 02:44:18', '2019-05-14 02:44:18'),
(24, 'add_settings', 'settings', '2019-05-14 02:44:18', '2019-05-14 02:44:18'),
(25, 'delete_settings', 'settings', '2019-05-14 02:44:19', '2019-05-14 02:44:19'),
(26, 'browse_categories', 'categories', '2019-05-14 02:44:33', '2019-05-14 02:44:33'),
(27, 'read_categories', 'categories', '2019-05-14 02:44:33', '2019-05-14 02:44:33'),
(28, 'edit_categories', 'categories', '2019-05-14 02:44:33', '2019-05-14 02:44:33'),
(29, 'add_categories', 'categories', '2019-05-14 02:44:33', '2019-05-14 02:44:33'),
(30, 'delete_categories', 'categories', '2019-05-14 02:44:33', '2019-05-14 02:44:33'),
(31, 'browse_posts', 'posts', '2019-05-14 02:44:37', '2019-05-14 02:44:37'),
(32, 'read_posts', 'posts', '2019-05-14 02:44:37', '2019-05-14 02:44:37'),
(33, 'edit_posts', 'posts', '2019-05-14 02:44:37', '2019-05-14 02:44:37'),
(34, 'add_posts', 'posts', '2019-05-14 02:44:37', '2019-05-14 02:44:37'),
(35, 'delete_posts', 'posts', '2019-05-14 02:44:37', '2019-05-14 02:44:37'),
(36, 'browse_pages', 'pages', '2019-05-14 02:44:38', '2019-05-14 02:44:38'),
(37, 'read_pages', 'pages', '2019-05-14 02:44:38', '2019-05-14 02:44:38'),
(38, 'edit_pages', 'pages', '2019-05-14 02:44:38', '2019-05-14 02:44:38'),
(39, 'add_pages', 'pages', '2019-05-14 02:44:39', '2019-05-14 02:44:39'),
(40, 'delete_pages', 'pages', '2019-05-14 02:44:39', '2019-05-14 02:44:39'),
(41, 'browse_hooks', NULL, '2019-05-14 02:44:44', '2019-05-14 02:44:44'),
(42, 'browse_permissions', 'permissions', '2019-05-14 04:22:04', '2019-05-14 04:22:04'),
(43, 'read_permissions', 'permissions', '2019-05-14 04:22:04', '2019-05-14 04:22:04'),
(44, 'edit_permissions', 'permissions', '2019-05-14 04:22:04', '2019-05-14 04:22:04'),
(45, 'add_permissions', 'permissions', '2019-05-14 04:22:04', '2019-05-14 04:22:04'),
(46, 'delete_permissions', 'permissions', '2019-05-14 04:22:04', '2019-05-14 04:22:04'),
(47, 'browse_sucursales', 'sucursales', '2019-05-18 18:13:59', '2019-05-18 18:13:59'),
(48, 'add_sucursales', 'sucursales', '2019-05-18 18:14:18', '2019-05-18 18:14:18'),
(49, 'edit_sucursales', 'sucursales', '2019-05-18 18:14:31', '2019-05-18 18:14:31'),
(50, 'delete_sucursales', 'sucursales', '2019-05-18 18:14:44', '2019-05-18 18:14:44'),
(62, 'browse_categorias', 'categorias', '2019-05-18 22:42:50', '2019-05-18 22:42:50'),
(63, 'read_categorias', 'categorias', '2019-05-18 22:42:50', '2019-05-18 22:42:50'),
(64, 'edit_categorias', 'categorias', '2019-05-18 22:42:50', '2019-05-18 22:42:50'),
(65, 'add_categorias', 'categorias', '2019-05-18 22:42:50', '2019-05-18 22:42:50'),
(66, 'delete_categorias', 'categorias', '2019-05-18 22:42:50', '2019-05-18 22:42:50'),
(67, 'browse_depositos', 'depositos', '2019-05-18 23:09:31', '2019-05-18 23:09:31'),
(68, 'view_depositos', 'depositos', '2019-05-18 23:17:14', '2019-05-18 23:17:42'),
(69, 'add_depositos', 'depositos', '2019-05-18 23:17:27', '2019-05-18 23:17:52'),
(70, 'edit_depositos', 'depositos', '2019-05-18 23:18:05', '2019-05-18 23:18:05'),
(71, 'delete_depositos', 'depositos', '2019-05-18 23:18:16', '2019-05-18 23:18:16'),
(72, 'browse_subcategorias', 'subcategorias', '2019-05-20 22:06:13', '2019-05-20 22:06:13'),
(73, 'read_subcategorias', 'subcategorias', '2019-05-20 22:06:13', '2019-05-20 22:06:13'),
(74, 'edit_subcategorias', 'subcategorias', '2019-05-20 22:06:13', '2019-05-20 22:06:13'),
(75, 'add_subcategorias', 'subcategorias', '2019-05-20 22:06:13', '2019-05-20 22:06:13'),
(76, 'delete_subcategorias', 'subcategorias', '2019-05-20 22:06:13', '2019-05-20 22:06:13'),
(77, 'browse_unidades', 'unidades', '2019-05-20 22:15:00', '2019-05-20 22:15:00'),
(78, 'read_unidades', 'unidades', '2019-05-20 22:15:00', '2019-05-20 22:15:00'),
(79, 'edit_unidades', 'unidades', '2019-05-20 22:15:00', '2019-05-20 22:15:00'),
(80, 'add_unidades', 'unidades', '2019-05-20 22:15:00', '2019-05-20 22:15:00'),
(81, 'delete_unidades', 'unidades', '2019-05-20 22:15:00', '2019-05-20 22:15:00'),
(82, 'browse_marcas', 'marcas', '2019-05-20 22:21:55', '2019-05-20 22:21:55'),
(83, 'read_marcas', 'marcas', '2019-05-20 22:21:55', '2019-05-20 22:21:55'),
(84, 'edit_marcas', 'marcas', '2019-05-20 22:21:55', '2019-05-20 22:21:55'),
(85, 'add_marcas', 'marcas', '2019-05-20 22:21:55', '2019-05-20 22:21:55'),
(86, 'delete_marcas', 'marcas', '2019-05-20 22:21:55', '2019-05-20 22:21:55'),
(87, 'browse_tallas', 'tallas', '2019-05-20 22:26:56', '2019-05-20 22:26:56'),
(88, 'read_tallas', 'tallas', '2019-05-20 22:26:56', '2019-05-20 22:26:56'),
(89, 'edit_tallas', 'tallas', '2019-05-20 22:26:56', '2019-05-20 22:26:56'),
(90, 'add_tallas', 'tallas', '2019-05-20 22:26:56', '2019-05-20 22:26:56'),
(91, 'delete_tallas', 'tallas', '2019-05-20 22:26:56', '2019-05-20 22:26:56'),
(92, 'browse_tamanios', 'tamanios', '2019-05-20 22:28:40', '2019-05-20 22:28:40'),
(93, 'read_tamanios', 'tamanios', '2019-05-20 22:28:40', '2019-05-20 22:28:40'),
(94, 'edit_tamanios', 'tamanios', '2019-05-20 22:28:40', '2019-05-20 22:28:40'),
(95, 'add_tamanios', 'tamanios', '2019-05-20 22:28:40', '2019-05-20 22:28:40'),
(96, 'delete_tamanios', 'tamanios', '2019-05-20 22:28:40', '2019-05-20 22:28:40'),
(97, 'browse_colores', 'colores', '2019-05-20 22:35:23', '2019-05-20 22:35:23'),
(98, 'read_colores', 'colores', '2019-05-20 22:35:23', '2019-05-20 22:35:23'),
(99, 'edit_colores', 'colores', '2019-05-20 22:35:23', '2019-05-20 22:35:23'),
(100, 'add_colores', 'colores', '2019-05-20 22:35:23', '2019-05-20 22:35:23'),
(101, 'delete_colores', 'colores', '2019-05-20 22:35:23', '2019-05-20 22:35:23'),
(102, 'browse_generos', 'generos', '2019-05-20 22:59:35', '2019-05-20 22:59:35'),
(103, 'read_generos', 'generos', '2019-05-20 22:59:35', '2019-05-20 22:59:35'),
(104, 'edit_generos', 'generos', '2019-05-20 22:59:35', '2019-05-20 22:59:35'),
(105, 'add_generos', 'generos', '2019-05-20 22:59:35', '2019-05-20 22:59:35'),
(106, 'delete_generos', 'generos', '2019-05-20 22:59:35', '2019-05-20 22:59:35'),
(107, 'browse_productos', 'productos', '2019-05-20 23:29:46', '2019-05-20 23:29:46'),
(108, 'view_productos', 'productos', '2019-05-20 23:30:04', '2019-05-20 23:30:04'),
(109, 'add_productos', 'productos', '2019-05-20 23:30:14', '2019-05-20 23:30:14'),
(110, 'edit_productos', 'productos', '2019-05-20 23:30:25', '2019-05-20 23:30:25'),
(111, 'delete_productos', 'productos', '2019-05-20 23:30:36', '2019-05-20 23:30:36'),
(112, 'view_sucursales', 'sucursales', '2019-05-20 23:36:13', '2019-05-20 23:36:13'),
(113, 'browse_usos', 'usos', '2019-05-21 01:02:15', '2019-05-21 01:02:15'),
(114, 'read_usos', 'usos', '2019-05-21 01:02:15', '2019-05-21 01:02:15'),
(115, 'edit_usos', 'usos', '2019-05-21 01:02:15', '2019-05-21 01:02:15'),
(116, 'add_usos', 'usos', '2019-05-21 01:02:15', '2019-05-21 01:02:15'),
(117, 'delete_usos', 'usos', '2019-05-21 01:02:15', '2019-05-21 01:02:15'),
(118, 'add_producto_depositos', 'depositos', '2019-05-22 20:17:37', '2019-05-22 20:17:37'),
(124, 'browse_monedas', 'monedas', '2019-05-23 02:29:41', '2019-05-23 02:29:41'),
(125, 'read_monedas', 'monedas', '2019-05-23 02:29:41', '2019-05-23 02:29:41'),
(126, 'edit_monedas', 'monedas', '2019-05-23 02:29:41', '2019-05-23 02:29:41'),
(127, 'add_monedas', 'monedas', '2019-05-23 02:29:41', '2019-05-23 02:29:41'),
(128, 'delete_monedas', 'monedas', '2019-05-23 02:29:41', '2019-05-23 02:29:41'),
(129, 'browse_costo_envios', 'costo_envios', '2019-05-24 01:57:25', '2019-05-24 01:57:25'),
(130, 'read_costo_envios', 'costo_envios', '2019-05-24 01:57:25', '2019-05-24 01:57:25'),
(131, 'edit_costo_envios', 'costo_envios', '2019-05-24 01:57:25', '2019-05-24 01:57:25'),
(132, 'add_costo_envios', 'costo_envios', '2019-05-24 01:57:25', '2019-05-24 01:57:25'),
(133, 'delete_costo_envios', 'costo_envios', '2019-05-24 01:57:25', '2019-05-24 01:57:25'),
(134, 'browse_ofertas', 'ofertas', '2019-05-27 21:32:50', '2019-05-27 21:32:50'),
(135, 'view_ofertas', 'ofertas', '2019-05-27 21:33:05', '2019-05-27 21:33:19'),
(136, 'add_ofertas', 'ofertas', '2019-05-27 21:33:34', '2019-05-27 21:33:34'),
(137, 'edit_ofertas', 'ofertas', '2019-05-27 21:33:49', '2019-05-27 21:33:49'),
(138, 'delete_ofertas', 'ofertas', '2019-05-27 21:34:05', '2019-05-27 21:34:05'),
(139, 'browse_ecommerce', 'ecommerce', '2019-05-28 20:37:12', '2019-05-28 20:37:12'),
(140, 'view_ecommerce', 'ecommerce', '2019-05-28 20:37:27', '2019-05-28 20:37:27'),
(141, 'add_ecommerce', 'ecommerce', '2019-05-28 20:37:42', '2019-05-28 20:37:42'),
(142, 'edit_ecommerce', 'ecommerce', '2019-05-28 20:37:55', '2019-05-28 20:37:55'),
(143, 'delete_ecommerce', 'ecommerce', '2019-05-28 20:38:10', '2019-05-28 20:38:10'),
(144, 'browse_cajas', 'cajas', '2019-06-14 20:35:45', '2019-06-14 20:35:45'),
(145, 'add_cajas', 'cajas', '2019-06-14 20:36:00', '2019-06-14 20:36:00'),
(146, 'view_cajas', 'cajas', '2019-06-14 20:36:20', '2019-06-14 21:21:58'),
(147, 'close_cajas', 'cajas', '2019-06-14 21:22:23', '2019-06-14 21:22:23'),
(148, 'browse_asientos', 'asientos', '2019-06-14 23:13:40', '2019-06-14 23:13:40'),
(149, 'add_asientos', 'asientos', '2019-06-14 23:14:16', '2019-06-14 23:14:16'),
(150, 'delete_asientos', 'asientos', '2019-06-14 23:14:27', '2019-06-14 23:14:27'),
(151, 'browse_insumos', 'insumos', '2019-06-15 01:19:56', '2019-06-15 01:19:56'),
(152, 'read_insumos', 'insumos', '2019-06-15 01:19:56', '2019-06-15 01:19:56'),
(153, 'edit_insumos', 'insumos', '2019-06-15 01:19:56', '2019-06-15 01:19:56'),
(154, 'add_insumos', 'insumos', '2019-06-15 01:19:56', '2019-06-15 01:19:56'),
(155, 'delete_insumos', 'insumos', '2019-06-15 01:19:56', '2019-06-15 01:19:56'),
(156, 'browse_compras', 'compras', '2019-06-18 22:33:12', '2019-06-18 22:33:12'),
(157, 'view_compras', 'compras', '2019-06-18 22:33:26', '2019-06-18 22:33:26'),
(158, 'add_compras', 'compras', '2019-06-18 22:33:39', '2019-06-18 22:33:39'),
(159, 'edit_compras', 'compras', '2019-06-18 22:33:52', '2019-06-18 22:33:52'),
(160, 'delete_compras', 'compras', '2019-06-18 22:34:06', '2019-06-18 22:34:06'),
(161, 'browse_proveedores', 'proveedores', '2019-06-19 01:32:00', '2019-06-19 01:32:00'),
(162, 'read_proveedores', 'proveedores', '2019-06-19 01:32:00', '2019-06-19 01:32:00'),
(163, 'edit_proveedores', 'proveedores', '2019-06-19 01:32:00', '2019-06-19 01:32:00'),
(164, 'add_proveedores', 'proveedores', '2019-06-19 01:32:00', '2019-06-19 01:32:00'),
(165, 'delete_proveedores', 'proveedores', '2019-06-19 01:32:00', '2019-06-19 01:32:00'),
(166, 'browse_clientes', 'clientes', '2019-06-19 19:11:59', '2019-06-19 19:11:59'),
(167, 'read_clientes', 'clientes', '2019-06-19 19:11:59', '2019-06-19 19:11:59'),
(168, 'edit_clientes', 'clientes', '2019-06-19 19:11:59', '2019-06-19 19:11:59'),
(169, 'add_clientes', 'clientes', '2019-06-19 19:11:59', '2019-06-19 19:11:59'),
(170, 'delete_clientes', 'clientes', '2019-06-19 19:11:59', '2019-06-19 19:11:59'),
(171, 'browse_ventas', 'ventas', '2019-06-19 19:13:30', '2019-06-19 19:13:30'),
(172, 'view_ventas', 'ventas', '2019-06-19 19:13:45', '2019-06-19 19:13:45'),
(173, 'add_ventas', 'ventas', '2019-06-19 19:14:03', '2019-06-19 19:14:03'),
(174, 'update_ventas', 'ventas', '2019-06-19 19:14:18', '2019-06-19 19:14:18'),
(175, 'delete_ventas', 'ventas', '2019-06-19 19:14:33', '2019-06-19 19:14:33'),
(181, 'browse_pasarela_pagos', 'pasarela_pagos', '2019-06-21 02:23:35', '2019-06-21 02:23:35'),
(182, 'read_pasarela_pagos', 'pasarela_pagos', '2019-06-21 02:23:35', '2019-06-21 02:23:35'),
(183, 'edit_pasarela_pagos', 'pasarela_pagos', '2019-06-21 02:23:35', '2019-06-21 02:23:35'),
(184, 'add_pasarela_pagos', 'pasarela_pagos', '2019-06-21 02:23:35', '2019-06-21 02:23:35'),
(185, 'delete_pasarela_pagos', 'pasarela_pagos', '2019-06-21 02:23:35', '2019-06-21 02:23:35'),
(186, 'browse_repartidores', 'repartidores', '2019-06-22 19:48:23', '2019-06-22 19:48:23'),
(187, 'read_repartidores', 'repartidores', '2019-06-22 19:48:23', '2019-06-22 19:48:23'),
(188, 'edit_repartidores', 'repartidores', '2019-06-22 19:48:23', '2019-06-22 19:48:23'),
(189, 'add_repartidores', 'repartidores', '2019-06-22 19:48:23', '2019-06-22 19:48:23'),
(190, 'delete_repartidores', 'repartidores', '2019-06-22 19:48:23', '2019-06-22 19:48:23'),
(191, 'browse_ventasdelivery', 'delivery', '2019-06-23 00:33:23', '2019-06-23 00:37:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(162, 1),
(163, 1),
(164, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(171, 1),
(171, 3),
(172, 1),
(172, 3),
(173, 1),
(173, 3),
(174, 1),
(175, 1),
(181, 1),
(182, 1),
(183, 1),
(184, 1),
(185, 1),
(186, 1),
(187, 1),
(188, 1),
(189, 1),
(190, 1),
(191, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` enum('PUBLISHED','DRAFT','PENDING') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `category_id`, `title`, `seo_title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(1, 0, NULL, 'Lorem Ipsum Post', NULL, 'This is the excerpt for the Lorem Ipsum Post', '<p>This is the body of the lorem ipsum post</p>', 'posts/post1.jpg', 'lorem-ipsum-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2019-05-14 02:44:37', '2019-05-14 02:44:37'),
(2, 0, NULL, 'My Sample Post', NULL, 'This is the excerpt for the sample Post', '<p>This is the body for the sample post, which includes the body.</p>\n                <h2>We can use all kinds of format!</h2>\n                <p>And include a bunch of other stuff.</p>', 'posts/post2.jpg', 'my-sample-post', 'Meta Description for sample post', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2019-05-14 02:44:37', '2019-05-14 02:44:37'),
(3, 0, NULL, 'Latest Post', NULL, 'This is the excerpt for the latest post', '<p>This is the body for the latest post</p>', 'posts/post3.jpg', 'latest-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2019-05-14 02:44:37', '2019-05-14 02:44:37'),
(4, 0, NULL, 'Yarr Post', NULL, 'Reef sails nipperkin bring a spring upon her cable coffer jury mast spike marooned Pieces of Eight poop deck pillage. Clipper driver coxswain galleon hempen halter come about pressgang gangplank boatswain swing the lead. Nipperkin yard skysail swab lanyard Blimey bilge water ho quarter Buccaneer.', '<p>Swab deadlights Buccaneer fire ship square-rigged dance the hempen jig weigh anchor cackle fruit grog furl. Crack Jennys tea cup chase guns pressgang hearties spirits hogshead Gold Road six pounders fathom measured fer yer chains. Main sheet provost come about trysail barkadeer crimp scuttle mizzenmast brig plunder.</p>\n<p>Mizzen league keelhaul galleon tender cog chase Barbary Coast doubloon crack Jennys tea cup. Blow the man down lugsail fire ship pinnace cackle fruit line warp Admiral of the Black strike colors doubloon. Tackle Jack Ketch come about crimp rum draft scuppers run a shot across the bow haul wind maroon.</p>\n<p>Interloper heave down list driver pressgang holystone scuppers tackle scallywag bilged on her anchor. Jack Tar interloper draught grapple mizzenmast hulk knave cable transom hogshead. Gaff pillage to go on account grog aft chase guns piracy yardarm knave clap of thunder.</p>', 'posts/post4.jpg', 'yarr-post', 'this be a meta descript', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2019-05-14 02:44:37', '2019-05-14 02:44:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios_compras`
--

CREATE TABLE `precios_compras` (
  `id` int(10) UNSIGNED NOT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `cantidad_minima` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `precios_compras`
--

INSERT INTO `precios_compras` (`id`, `monto`, `cantidad_minima`, `producto_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '912.00', 1, 1, '2019-06-05 02:53:50', '2019-06-05 02:53:50', '2019-06-05 03:03:37'),
(2, '912.00', 1, 1, '2019-06-05 03:03:37', '2019-06-05 03:03:37', NULL),
(3, '38.00', 1, 2, '2019-06-05 04:46:37', '2019-06-05 04:46:37', '2019-06-05 04:48:35'),
(4, '34.00', 3, 2, '2019-06-05 04:46:37', '2019-06-05 04:46:37', '2019-06-05 04:48:35'),
(5, '38.00', 1, 2, '2019-06-05 04:48:35', '2019-06-05 04:48:35', NULL),
(6, '34.00', 3, 2, '2019-06-05 04:48:35', '2019-06-05 04:48:35', NULL),
(7, '1238.00', 1, 3, '2019-06-05 20:28:43', '2019-06-05 20:28:43', '2019-06-05 20:29:56'),
(8, '1238.00', 1, 3, '2019-06-05 20:29:56', '2019-06-05 20:29:56', NULL),
(9, '155.00', 1, 4, '2019-06-14 01:34:06', '2019-06-14 01:34:06', NULL),
(10, '145.00', 3, 4, '2019-06-14 01:34:06', '2019-06-14 01:34:06', NULL),
(11, '196.00', 1, 5, '2019-06-14 04:27:41', '2019-06-14 04:27:41', NULL),
(12, '209.00', 3, 5, '2019-06-14 04:27:41', '2019-06-14 04:27:41', NULL),
(13, '260.00', 1, 6, '2019-06-14 04:55:13', '2019-06-14 04:55:13', NULL),
(14, '250.00', 3, 6, '2019-06-14 04:55:13', '2019-06-14 04:55:13', NULL),
(15, '250.00', 1, 7, '2019-06-14 18:58:18', '2019-06-14 18:58:18', '2019-06-14 19:02:48'),
(16, '270.00', 3, 7, '2019-06-14 18:58:18', '2019-06-14 18:58:18', '2019-06-14 19:02:48'),
(17, '250.00', 1, 7, '2019-06-14 19:02:48', '2019-06-14 19:02:48', NULL),
(18, '270.00', 3, 7, '2019-06-14 19:02:48', '2019-06-14 19:02:48', NULL),
(19, '265.00', 1, 8, '2019-06-14 19:14:13', '2019-06-14 19:14:13', NULL),
(20, '260.00', 3, 8, '2019-06-14 19:14:13', '2019-06-14 19:14:13', NULL),
(21, '410.00', 1, 9, '2019-06-14 19:24:30', '2019-06-14 19:24:30', NULL),
(22, '390.00', 3, 9, '2019-06-14 19:24:30', '2019-06-14 19:24:30', NULL),
(23, '315.00', 1, 10, '2019-06-14 19:49:02', '2019-06-14 19:49:02', '2019-06-14 20:08:04'),
(24, '315.00', 1, 10, '2019-06-14 20:08:04', '2019-06-14 20:08:04', NULL),
(25, '45.00', 1, 11, '2019-06-14 20:37:07', '2019-06-14 20:37:07', NULL),
(26, '40.00', 3, 11, '2019-06-14 20:37:07', '2019-06-14 20:37:07', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion_small` text COLLATE utf8mb4_unicode_ci,
  `descripcion_long` text COLLATE utf8mb4_unicode_ci,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `precio_minimo` decimal(10,2) DEFAULT NULL,
  `ultimo_precio_compra` decimal(10,2) DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_grupo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_barras` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bloque` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `codigo_interno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcategoria_id` int(11) DEFAULT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `talla_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `genero_id` int(11) DEFAULT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  `uso_id` int(11) DEFAULT NULL,
  `modelo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moneda_id` int(11) DEFAULT NULL,
  `garantia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catalogo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nuevo` int(11) DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vistas` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion_small`, `descripcion_long`, `precio_venta`, `precio_minimo`, `ultimo_precio_compra`, `codigo`, `codigo_grupo`, `codigo_barras`, `estante`, `bloque`, `stock`, `stock_minimo`, `codigo_interno`, `subcategoria_id`, `marca_id`, `talla_id`, `color_id`, `genero_id`, `unidad_id`, `uso_id`, `modelo`, `moneda_id`, `garantia`, `catalogo`, `nuevo`, `imagen`, `vistas`) VALUES
(1, 'Pizza 1', 'Pizza mediana...', NULL, NULL, NULL, NULL, 'COD-00001', '1', '2019061900001', NULL, NULL, NULL, NULL, NULL, 10, 1, 1, 1, 1, NULL, 1, NULL, 2, NULL, '', NULL, 'productos/June2019/GzLMTcoXczeZXJhjYby5.jpg', 29),
(2, 'Hamburguesa 1', 'Hamburguesa completa ....', NULL, NULL, NULL, NULL, 'COD-00002', '2', '2019061900002', NULL, NULL, NULL, NULL, NULL, 11, 1, 1, 1, 1, NULL, 1, NULL, 2, NULL, '', NULL, 'productos/June2019/LYBHKvsHRoQrkorcn2Rr.jpg', 27),
(3, 'Coca cola 2 litros', 'Cocacola...', NULL, NULL, NULL, NULL, 'COD-00003', '3', '2019061900003', NULL, NULL, NULL, NULL, NULL, 12, 1, 1, 1, 1, NULL, 1, NULL, 2, NULL, '', NULL, 'productos/June2019/FWKUv0HReP9A2vSDl4VR.jpg', 2),
(4, 'Lomito', 'NN', NULL, NULL, NULL, NULL, 'COD-00004', '4', '2019061900004', NULL, NULL, NULL, NULL, NULL, 13, 1, 1, 1, 1, NULL, 1, NULL, 2, NULL, '', 1, 'productos/June2019/Xlt7Lt2oqiiVkTOA2lwG.jpg', 2),
(5, 'Sprite 2 litros', 'nn', NULL, NULL, NULL, NULL, 'COD-00005', '5', '2019061900005', NULL, NULL, NULL, NULL, NULL, 12, 1, 1, 1, 1, NULL, 1, NULL, 2, NULL, '', NULL, 'productos/June2019/sXHmaY4sGAxy03f8Ozib.jpg', 0),
(6, 'Chicharrón de pollo', 'nn', NULL, NULL, NULL, NULL, 'COD-00006', '6', '2019062000006', NULL, NULL, NULL, NULL, NULL, 14, 1, 1, 1, 1, NULL, 1, NULL, 2, NULL, '', NULL, 'productos/June2019/Cgi2jcz3naJOeGAnTMsw.jpg', 0),
(7, 'Silpancho', 'nn', NULL, NULL, NULL, NULL, 'COD-00007', '7', '2019062000007', NULL, NULL, NULL, NULL, NULL, 15, 1, 1, 1, 1, NULL, 1, NULL, 2, NULL, '', NULL, 'productos/June2019/NqKGCD9DgCfYLFBS6UFv.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_comentarios`
--

CREATE TABLE `productos_comentarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_insumos`
--

CREATE TABLE `productos_insumos` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `insumo_id` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos_insumos`
--

INSERT INTO `productos_insumos` (`id`, `producto_id`, `insumo_id`, `cantidad`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 12, 1, '0.00', '2019-06-18 18:26:19', '2019-06-18 18:26:19', NULL),
(2, 12, 2, '0.00', '2019-06-18 18:26:19', '2019-06-18 18:26:19', NULL),
(3, 13, 2, '12.00', '2019-06-18 18:29:31', '2019-06-18 18:29:31', NULL),
(4, 13, 3, '13.00', '2019-06-18 18:29:31', '2019-06-18 18:29:31', NULL),
(5, 14, 1, '0.00', '2019-06-18 18:30:07', '2019-06-18 18:30:07', '2019-06-18 19:51:06'),
(6, 14, 2, '0.00', '2019-06-18 18:30:07', '2019-06-18 18:30:07', '2019-06-18 19:51:06'),
(7, 15, 1, '0.50', '2019-06-18 18:31:33', '2019-06-18 18:31:33', '2019-06-18 19:50:29'),
(8, 15, 2, '0.20', '2019-06-18 18:31:33', '2019-06-18 18:31:33', '2019-06-18 19:50:29'),
(9, 15, 1, '0.50', '2019-06-18 19:29:25', '2019-06-18 19:29:25', '2019-06-18 19:50:29'),
(10, 15, 3, '2.00', '2019-06-18 19:29:25', '2019-06-18 19:29:25', '2019-06-18 19:50:29'),
(11, 15, 1, '0.50', '2019-06-18 19:45:19', '2019-06-18 19:45:19', '2019-06-18 19:50:29'),
(12, 15, 3, '2.00', '2019-06-18 19:45:19', '2019-06-18 19:45:19', '2019-06-18 19:50:29'),
(13, 15, 4, '0.20', '2019-06-18 19:45:19', '2019-06-18 19:45:19', '2019-06-18 19:50:29'),
(14, 15, 1, '0.50', '2019-06-18 19:50:29', '2019-06-18 19:50:29', NULL),
(15, 15, 3, '2.00', '2019-06-18 19:50:29', '2019-06-18 19:50:29', NULL),
(16, 15, 4, '0.20', '2019-06-18 19:50:29', '2019-06-18 19:50:29', NULL),
(17, 14, 1, '3.00', '2019-06-18 19:51:06', '2019-06-18 19:51:06', NULL),
(18, 14, 2, '2.00', '2019-06-18 19:51:06', '2019-06-18 19:51:06', NULL),
(19, 4, 1, '0.20', '2019-06-19 21:24:52', '2019-06-19 21:24:52', NULL),
(20, 4, 2, '0.50', '2019-06-19 21:24:52', '2019-06-19 21:24:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_puntuaciones`
--

CREATE TABLE `productos_puntuaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `puntos` int(11) DEFAULT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos_puntuaciones`
--

INSERT INTO `productos_puntuaciones` (`id`, `producto_id`, `user_id`, `puntos`, `comentario`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 5, NULL, '2019-06-05 04:58:12', '2019-06-05 04:58:12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

CREATE TABLE `producto_imagenes` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `imagen` text COLLATE utf8mb4_unicode_ci,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_imagenes`
--

INSERT INTO `producto_imagenes` (`id`, `producto_id`, `imagen`, `tipo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(15, 1, 'productos/June2019/GzLMTcoXczeZXJhjYby5.jpg', 'principal', '2019-06-19 19:52:16', '2019-06-19 19:52:16', NULL),
(16, 2, 'productos/June2019/LYBHKvsHRoQrkorcn2Rr.jpg', 'principal', '2019-06-19 19:52:56', '2019-06-19 19:52:56', NULL),
(17, 3, 'productos/June2019/FWKUv0HReP9A2vSDl4VR.jpg', 'principal', '2019-06-19 19:53:46', '2019-06-19 19:53:46', NULL),
(18, 4, 'productos/June2019/Xlt7Lt2oqiiVkTOA2lwG.jpg', 'principal', '2019-06-19 21:24:52', '2019-06-19 21:24:52', NULL),
(19, 5, 'productos/June2019/sXHmaY4sGAxy03f8Ozib.jpg', 'principal', '2019-06-19 21:50:37', '2019-06-19 21:50:37', NULL),
(20, 6, 'productos/June2019/Cgi2jcz3naJOeGAnTMsw.jpg', 'principal', '2019-06-20 19:26:56', '2019-06-20 19:26:56', NULL),
(21, 7, 'productos/June2019/NqKGCD9DgCfYLFBS6UFv.jpg', 'principal', '2019-06-20 19:27:36', '2019-06-20 19:27:36', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_unidades`
--

CREATE TABLE `producto_unidades` (
  `id` int(10) UNSIGNED NOT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `precio_minimo` decimal(10,2) DEFAULT NULL,
  `cantidad_pieza` int(11) DEFAULT '1',
  `cantidad_minima` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_unidades`
--

INSERT INTO `producto_unidades` (`id`, `unidad_id`, `producto_id`, `precio`, `precio_minimo`, `cantidad_pieza`, `cantidad_minima`, `created_at`, `updated_at`, `deleted_at`) VALUES
(33, 1, 1, '40.00', '0.00', 1, 1, '2019-06-19 19:52:16', '2019-06-19 19:52:16', NULL),
(34, 1, 2, '12.00', '0.00', 1, 1, '2019-06-19 19:52:56', '2019-06-19 19:52:56', NULL),
(35, 1, 3, '12.00', '0.00', 1, 1, '2019-06-19 19:53:46', '2019-06-19 19:53:46', NULL),
(36, 1, 4, '15.00', '0.00', 1, 1, '2019-06-19 21:24:52', '2019-06-19 21:24:52', NULL),
(37, 1, 5, '12.00', '0.00', 1, 1, '2019-06-19 21:50:37', '2019-06-19 21:50:37', NULL),
(38, 1, 6, '20.00', '0.00', 1, 1, '2019-06-20 19:26:56', '2019-06-20 19:26:56', NULL),
(39, 1, 7, '12.00', '0.00', 1, 1, '2019-06-20 19:27:36', '2019-06-20 19:27:36', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(10) UNSIGNED NOT NULL,
  `nit` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movil` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nit`, `nombre`, `telefono`, `movil`, `mail`, `direccion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '12345', 'SIN NOMBRE', NULL, NULL, NULL, NULL, '2019-04-30 16:22:12', '2019-04-30 16:22:12', NULL),
(2, '123456', 'Mario Nosa', NULL, NULL, NULL, NULL, '2019-06-19 01:54:41', '2019-06-19 01:54:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartidores`
--

CREATE TABLE `repartidores` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `movil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `repartidores`
--

INSERT INTO `repartidores` (`id`, `nombre`, `direccion`, `movil`, `foto`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Repartido1', 'NN', '756565464', 'repartidores\\June2019\\FPtm9TkAAI2wVrrhX6IC.png', 9, NULL, '2019-06-23 00:09:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartidores_pedidos`
--

CREATE TABLE `repartidores_pedidos` (
  `id` int(10) UNSIGNED NOT NULL,
  `repartidor_id` int(11) DEFAULT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `repartidores_pedidos`
--

INSERT INTO `repartidores_pedidos` (`id`, `repartidor_id`, `pedido_id`, `estado`, `lat`, `lon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 60, 1, NULL, NULL, NULL, NULL, NULL),
(2, 1, 61, 1, NULL, NULL, '2019-06-22 22:43:57', '2019-06-22 22:43:57', NULL),
(3, 1, 62, 1, '-14.795384499999999', '-64.8703867', '2019-06-22 22:51:00', '2019-06-23 02:22:32', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartidores_ubicaciones`
--

CREATE TABLE `repartidores_ubicaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `repartidor_pedido_id` int(11) DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `repartidores_ubicaciones`
--

INSERT INTO `repartidores_ubicaciones` (`id`, `repartidor_pedido_id`, `lat`, `lon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(45, 3, '-16.5', '-68.1499', '2019-06-24 19:00:54', '2019-06-24 19:00:54', NULL),
(46, 3, '-16.5', '-68.1499', '2019-06-24 19:01:06', '2019-06-24 19:01:06', NULL),
(47, 3, '-16.5', '-68.1499', '2019-06-24 19:01:14', '2019-06-24 19:01:14', NULL),
(48, 3, '-16.5', '-68.1499', '2019-06-24 19:01:24', '2019-06-24 19:01:24', NULL),
(49, 3, '-16.5', '-68.1499', '2019-06-24 19:01:34', '2019-06-24 19:01:34', NULL),
(50, 3, '-16.5', '-68.1499', '2019-06-24 19:01:44', '2019-06-24 19:01:44', NULL),
(51, 3, '-16.5', '-68.1499', '2019-06-24 19:01:54', '2019-06-24 19:01:54', NULL),
(52, 3, '-16.5', '-68.1499', '2019-06-24 19:02:04', '2019-06-24 19:02:04', NULL),
(53, 3, '-16.5', '-68.1499', '2019-06-24 19:02:14', '2019-06-24 19:02:14', NULL),
(54, 3, '-16.5', '-68.1499', '2019-06-24 19:02:24', '2019-06-24 19:02:24', NULL),
(55, 3, '-16.5', '-68.1499', '2019-06-24 19:02:34', '2019-06-24 19:02:34', NULL),
(56, 3, '-16.5', '-68.1499', '2019-06-24 19:02:45', '2019-06-24 19:02:45', NULL),
(57, 3, '-16.5', '-68.1499', '2019-06-24 19:02:54', '2019-06-24 19:02:54', NULL),
(58, 3, '-16.5', '-68.1499', '2019-06-24 19:03:06', '2019-06-24 19:03:06', NULL),
(59, 3, '-16.5', '-68.1499', '2019-06-24 19:03:14', '2019-06-24 19:03:14', NULL),
(60, 3, '-16.5', '-68.1499', '2019-06-24 19:03:24', '2019-06-24 19:03:24', NULL),
(61, 3, '-16.5', '-68.1499', '2019-06-24 19:03:34', '2019-06-24 19:03:34', NULL),
(62, 3, '-16.5', '-68.1499', '2019-06-24 19:03:47', '2019-06-24 19:03:47', NULL),
(63, 3, '-16.5', '-68.1499', '2019-06-24 19:03:54', '2019-06-24 19:03:54', NULL),
(64, 3, '-16.5', '-68.1499', '2019-06-24 19:04:04', '2019-06-24 19:04:04', NULL),
(65, 3, '-16.5', '-68.1499', '2019-06-24 19:04:14', '2019-06-24 19:04:14', NULL),
(66, 3, '-16.5', '-68.1499', '2019-06-24 19:04:24', '2019-06-24 19:04:24', NULL),
(67, 3, '-16.5', '-68.1499', '2019-06-24 19:04:34', '2019-06-24 19:04:34', NULL),
(68, 3, '-16.5', '-68.1499', '2019-06-24 19:04:44', '2019-06-24 19:04:44', NULL),
(69, 3, '-16.5', '-68.1499', '2019-06-24 19:04:54', '2019-06-24 19:04:54', NULL),
(70, 3, '-16.5', '-68.1499', '2019-06-24 19:05:04', '2019-06-24 19:05:04', NULL),
(71, 3, '-16.5', '-68.1499', '2019-06-24 19:05:14', '2019-06-24 19:05:14', NULL),
(72, 3, '-16.5', '-68.1499', '2019-06-24 19:05:24', '2019-06-24 19:05:24', NULL),
(73, 3, '-16.5', '-68.1499', '2019-06-24 19:05:34', '2019-06-24 19:05:34', NULL),
(74, 3, '-16.5', '-68.1499', '2019-06-24 19:05:44', '2019-06-24 19:05:44', NULL),
(75, 3, '-16.5', '-68.1499', '2019-06-24 19:05:54', '2019-06-24 19:05:54', NULL),
(76, 3, '-16.5', '-68.1499', '2019-06-24 19:06:06', '2019-06-24 19:06:06', NULL),
(77, 3, '-16.5', '-68.1499', '2019-06-24 19:06:14', '2019-06-24 19:06:14', NULL),
(78, 3, '-16.5', '-68.1499', '2019-06-24 19:06:26', '2019-06-24 19:06:26', NULL),
(79, 3, '-16.5', '-68.1499', '2019-06-24 19:06:34', '2019-06-24 19:06:34', NULL),
(80, 3, '-16.5', '-68.1499', '2019-06-24 19:06:46', '2019-06-24 19:06:46', NULL),
(81, 3, '-16.5', '-68.1499', '2019-06-24 19:06:55', '2019-06-24 19:06:55', NULL),
(82, 3, '-16.5', '-68.1499', '2019-06-24 19:07:06', '2019-06-24 19:07:06', NULL),
(83, 3, '-16.5', '-68.1499', '2019-06-24 19:07:14', '2019-06-24 19:07:14', NULL),
(84, 3, '-16.5', '-68.1499', '2019-06-24 19:07:26', '2019-06-24 19:07:26', NULL),
(85, 3, '-16.5', '-68.1499', '2019-06-24 19:07:34', '2019-06-24 19:07:34', NULL),
(86, 3, '-16.5', '-68.1499', '2019-06-24 19:07:46', '2019-06-24 19:07:46', NULL),
(87, 3, '-16.5', '-68.1499', '2019-06-24 19:07:54', '2019-06-24 19:07:54', NULL),
(88, 3, '-16.5', '-68.1499', '2019-06-24 19:08:06', '2019-06-24 19:08:06', NULL),
(89, 3, '-16.5', '-68.1499', '2019-06-24 19:08:14', '2019-06-24 19:08:14', NULL),
(90, 3, '-16.5', '-68.1499', '2019-06-24 19:08:24', '2019-06-24 19:08:24', NULL),
(91, 3, '-16.5', '-68.1499', '2019-06-24 19:08:34', '2019-06-24 19:08:34', NULL),
(92, 3, '-16.5', '-68.1499', '2019-06-24 19:08:44', '2019-06-24 19:08:44', NULL),
(93, 3, '-16.5', '-68.1499', '2019-06-24 19:08:54', '2019-06-24 19:08:54', NULL),
(94, 3, '-16.5', '-68.1499', '2019-06-24 19:09:06', '2019-06-24 19:09:06', NULL),
(95, 3, '-16.5', '-68.1499', '2019-06-24 19:09:14', '2019-06-24 19:09:14', NULL),
(96, 3, '-16.5', '-68.1499', '2019-06-24 19:09:26', '2019-06-24 19:09:26', NULL),
(97, 3, '-16.5', '-68.1499', '2019-06-24 19:09:34', '2019-06-24 19:09:34', NULL),
(98, 3, '-16.5', '-68.1499', '2019-06-24 19:09:44', '2019-06-24 19:09:44', NULL),
(99, 3, '-16.5', '-68.1499', '2019-06-24 19:09:54', '2019-06-24 19:09:54', NULL),
(100, 3, '-16.5', '-68.1499', '2019-06-24 19:10:04', '2019-06-24 19:10:04', NULL),
(101, 3, '-16.5', '-68.1499', '2019-06-24 19:10:14', '2019-06-24 19:10:14', NULL),
(102, 3, '-16.5', '-68.1499', '2019-06-24 19:10:24', '2019-06-24 19:10:24', NULL),
(103, 3, '-16.5', '-68.1499', '2019-06-24 19:10:34', '2019-06-24 19:10:34', NULL),
(104, 3, '-16.5', '-68.1499', '2019-06-24 19:10:44', '2019-06-24 19:10:44', NULL),
(105, 3, '-16.5', '-68.1499', '2019-06-24 19:10:54', '2019-06-24 19:10:54', NULL),
(106, 3, '-16.5', '-68.1499', '2019-06-24 19:11:06', '2019-06-24 19:11:06', NULL),
(107, 3, '-16.5', '-68.1499', '2019-06-24 19:11:14', '2019-06-24 19:11:14', NULL),
(108, 3, '-16.5', '-68.1499', '2019-06-24 19:11:24', '2019-06-24 19:11:24', NULL),
(109, 3, '-16.5', '-68.1499', '2019-06-24 19:11:34', '2019-06-24 19:11:34', NULL),
(110, 3, '-16.5', '-68.1499', '2019-06-24 19:11:44', '2019-06-24 19:11:44', NULL),
(111, 3, '-16.5', '-68.1499', '2019-06-24 19:11:54', '2019-06-24 19:11:54', NULL),
(112, 3, '-16.5', '-68.1499', '2019-06-24 19:12:04', '2019-06-24 19:12:04', NULL),
(113, 3, '-16.5', '-68.1499', '2019-06-24 19:12:14', '2019-06-24 19:12:14', NULL),
(114, 3, '-16.5', '-68.1499', '2019-06-24 19:12:24', '2019-06-24 19:12:24', NULL),
(115, 3, '-16.5', '-68.1499', '2019-06-24 19:12:34', '2019-06-24 19:12:34', NULL),
(116, 3, '-16.5', '-68.1499', '2019-06-24 19:12:44', '2019-06-24 19:12:44', NULL),
(117, 3, '-16.5', '-68.1499', '2019-06-24 19:12:55', '2019-06-24 19:12:55', NULL),
(118, 3, '-16.5', '-68.1499', '2019-06-24 19:13:05', '2019-06-24 19:13:05', NULL),
(119, 3, '-16.5', '-68.1499', '2019-06-24 19:13:14', '2019-06-24 19:13:14', NULL),
(120, 3, '-16.5', '-68.1499', '2019-06-24 19:13:25', '2019-06-24 19:13:25', NULL),
(121, 3, '-16.5', '-68.1499', '2019-06-24 19:13:35', '2019-06-24 19:13:35', NULL),
(122, 3, '-16.5', '-68.1499', '2019-06-24 19:13:46', '2019-06-24 19:13:46', NULL),
(123, 3, '-16.5', '-68.1499', '2019-06-24 19:13:54', '2019-06-24 19:13:54', NULL),
(124, 3, '-16.5', '-68.1499', '2019-06-24 19:14:04', '2019-06-24 19:14:04', NULL),
(125, 3, '-16.5', '-68.1499', '2019-06-24 19:14:14', '2019-06-24 19:14:14', NULL),
(126, 3, '-16.5', '-68.1499', '2019-06-24 19:14:24', '2019-06-24 19:14:24', NULL),
(127, 3, '-16.5', '-68.1499', '2019-06-24 19:14:35', '2019-06-24 19:14:35', NULL),
(128, 3, '-16.5', '-68.1499', '2019-06-24 19:14:45', '2019-06-24 19:14:45', NULL),
(129, 3, '-16.5', '-68.1499', '2019-06-24 19:14:54', '2019-06-24 19:14:54', NULL),
(130, 3, '-16.5', '-68.1499', '2019-06-24 19:15:06', '2019-06-24 19:15:06', NULL),
(131, 3, '-16.5', '-68.1499', '2019-06-24 19:15:15', '2019-06-24 19:15:15', NULL),
(132, 3, '-16.5', '-68.1499', '2019-06-24 19:15:25', '2019-06-24 19:15:25', NULL),
(133, 3, '-16.5', '-68.1499', '2019-06-24 19:15:35', '2019-06-24 19:15:35', NULL),
(134, 3, '-16.5', '-68.1499', '2019-06-24 19:15:44', '2019-06-24 19:15:44', NULL),
(135, 3, '-16.5', '-68.1499', '2019-06-24 19:15:54', '2019-06-24 19:15:54', NULL),
(136, 3, '-16.5', '-68.1499', '2019-06-24 19:16:04', '2019-06-24 19:16:04', NULL),
(137, 3, '-16.5', '-68.1499', '2019-06-24 19:16:14', '2019-06-24 19:16:14', NULL),
(138, 3, '-16.5', '-68.1499', '2019-06-24 19:16:26', '2019-06-24 19:16:26', NULL),
(139, 3, '-16.5', '-68.1499', '2019-06-24 19:16:34', '2019-06-24 19:16:34', NULL),
(140, 3, '-16.5', '-68.1499', '2019-06-24 19:16:44', '2019-06-24 19:16:44', NULL),
(141, 3, '-16.5', '-68.1499', '2019-06-24 19:16:54', '2019-06-24 19:16:54', NULL),
(142, 3, '-16.5', '-68.1499', '2019-06-24 19:17:04', '2019-06-24 19:17:04', NULL),
(143, 3, '-16.5', '-68.1499', '2019-06-24 19:17:14', '2019-06-24 19:17:14', NULL),
(144, 3, '-16.5', '-68.1499', '2019-06-24 19:17:24', '2019-06-24 19:17:24', NULL),
(145, 3, '-16.5', '-68.1499', '2019-06-24 19:17:34', '2019-06-24 19:17:34', NULL),
(146, 3, '-16.5', '-68.1499', '2019-06-24 19:17:47', '2019-06-24 19:17:47', NULL),
(147, 3, '-16.5', '-68.1499', '2019-06-24 19:17:54', '2019-06-24 19:17:54', NULL),
(148, 3, '-16.5', '-68.1499', '2019-06-24 19:18:06', '2019-06-24 19:18:06', NULL),
(149, 3, '-16.5', '-68.1499', '2019-06-24 19:18:14', '2019-06-24 19:18:14', NULL),
(150, 3, '-16.5', '-68.1499', '2019-06-24 19:18:26', '2019-06-24 19:18:26', NULL),
(151, 3, '-16.5', '-68.1499', '2019-06-24 19:18:34', '2019-06-24 19:18:34', NULL),
(152, 3, '-16.5', '-68.1499', '2019-06-24 19:49:20', '2019-06-24 19:49:20', NULL),
(153, 3, '-16.5', '-68.1499', '2019-06-24 19:49:29', '2019-06-24 19:49:29', NULL),
(154, 3, '-16.5', '-68.1499', '2019-06-24 19:49:39', '2019-06-24 19:49:39', NULL),
(155, 3, '-16.5', '-68.1499', '2019-06-24 19:49:50', '2019-06-24 19:49:50', NULL),
(156, 3, '-16.5', '-68.1499', '2019-06-24 19:50:10', '2019-06-24 19:50:10', NULL),
(157, 3, '-16.5', '-68.1499', '2019-06-24 19:50:20', '2019-06-24 19:50:20', NULL),
(158, 3, '-16.5', '-68.1499', '2019-06-24 19:50:30', '2019-06-24 19:50:30', NULL),
(159, 3, '-16.5', '-68.1499', '2019-06-24 19:50:41', '2019-06-24 19:50:41', NULL),
(160, 3, '-16.5', '-68.1499', '2019-06-24 19:50:50', '2019-06-24 19:50:50', NULL),
(161, 3, '-16.5', '-68.1499', '2019-06-24 19:51:00', '2019-06-24 19:51:00', NULL),
(162, 3, '-16.5', '-68.1499', '2019-06-24 19:51:10', '2019-06-24 19:51:10', NULL),
(163, 3, '-16.5', '-68.1499', '2019-06-24 19:51:20', '2019-06-24 19:51:20', NULL),
(164, 3, '-16.5', '-68.1499', '2019-06-24 19:51:30', '2019-06-24 19:51:30', NULL),
(165, 3, '-16.5', '-68.1499', '2019-06-24 19:51:40', '2019-06-24 19:51:40', NULL),
(166, 3, '-16.5', '-68.1499', '2019-06-24 19:51:50', '2019-06-24 19:51:50', NULL),
(167, 3, '-16.5', '-68.1499', '2019-06-24 19:52:04', '2019-06-24 19:52:04', NULL),
(168, 3, '-16.5', '-68.1499', '2019-06-24 19:52:16', '2019-06-24 19:52:16', NULL),
(169, 3, '-16.5', '-68.1499', '2019-06-24 19:52:24', '2019-06-24 19:52:24', NULL),
(170, 3, '-16.5', '-68.1499', '2019-06-24 19:52:34', '2019-06-24 19:52:34', NULL),
(171, 3, '-16.5', '-68.1499', '2019-06-24 19:52:44', '2019-06-24 19:52:44', NULL),
(172, 3, '-16.5', '-68.1499', '2019-06-24 19:52:54', '2019-06-24 19:52:54', NULL),
(173, 3, '-16.5', '-68.1499', '2019-06-24 19:53:04', '2019-06-24 19:53:04', NULL),
(174, 3, '-16.5', '-68.1499', '2019-06-24 19:53:14', '2019-06-24 19:53:14', NULL),
(175, 3, '-16.5', '-68.1499', '2019-06-24 19:53:24', '2019-06-24 19:53:24', NULL),
(176, 3, '-16.5', '-68.1499', '2019-06-24 19:53:42', '2019-06-24 19:53:42', NULL),
(177, 3, '-16.5', '-68.1499', '2019-06-24 19:53:54', '2019-06-24 19:53:54', NULL),
(178, 3, '-16.5', '-68.1499', '2019-06-24 19:54:02', '2019-06-24 19:54:02', NULL),
(179, 3, '-16.5', '-68.1499', '2019-06-24 19:54:12', '2019-06-24 19:54:12', NULL),
(180, 3, '-16.5', '-68.1499', '2019-06-24 19:54:22', '2019-06-24 19:54:22', NULL),
(181, 3, '-16.5', '-68.1499', '2019-06-24 19:54:32', '2019-06-24 19:54:32', NULL),
(182, 3, '-16.5', '-68.1499', '2019-06-24 19:54:42', '2019-06-24 19:54:42', NULL),
(183, 3, '-16.5', '-68.1499', '2019-06-24 19:54:52', '2019-06-24 19:54:52', NULL),
(184, 3, '-16.5', '-68.1499', '2019-06-24 19:55:02', '2019-06-24 19:55:02', NULL),
(185, 3, '-16.5', '-68.1499', '2019-06-24 19:55:21', '2019-06-24 19:55:21', NULL),
(186, 3, '-16.5', '-68.1499', '2019-06-24 19:55:32', '2019-06-24 19:55:32', NULL),
(187, 3, '-16.5', '-68.1499', '2019-06-24 19:55:42', '2019-06-24 19:55:42', NULL),
(188, 3, '-16.5', '-68.1499', '2019-06-24 19:55:56', '2019-06-24 19:55:56', NULL),
(189, 3, '-16.5', '-68.1499', '2019-06-24 19:56:06', '2019-06-24 19:56:06', NULL),
(190, 3, '-16.5', '-68.1499', '2019-06-24 19:56:21', '2019-06-24 19:56:21', NULL),
(191, 3, '-16.5', '-68.1499', '2019-06-24 19:56:31', '2019-06-24 19:56:31', NULL),
(192, 3, '-16.5', '-68.1499', '2019-06-24 19:56:41', '2019-06-24 19:56:41', NULL),
(193, 3, '-16.5', '-68.1499', '2019-06-24 19:56:51', '2019-06-24 19:56:51', NULL),
(194, 3, '-16.5', '-68.1499', '2019-06-24 19:57:01', '2019-06-24 19:57:01', NULL),
(195, 3, '-16.5', '-68.1499', '2019-06-24 19:57:11', '2019-06-24 19:57:11', NULL),
(196, 3, '-16.5', '-68.1499', '2019-06-24 19:57:21', '2019-06-24 19:57:21', NULL),
(197, 3, '-16.5', '-68.1499', '2019-06-24 19:57:31', '2019-06-24 19:57:31', NULL),
(198, 3, '-16.5', '-68.1499', '2019-06-24 19:57:41', '2019-06-24 19:57:41', NULL),
(199, 3, '-16.5', '-68.1499', '2019-06-24 19:58:01', '2019-06-24 19:58:01', NULL),
(200, 3, '-16.5', '-68.1499', '2019-06-24 19:58:11', '2019-06-24 19:58:11', NULL),
(201, 3, '-16.5', '-68.1499', '2019-06-24 19:58:21', '2019-06-24 19:58:21', NULL),
(202, 3, '-16.5', '-68.1499', '2019-06-24 19:58:31', '2019-06-24 19:58:31', NULL),
(203, 3, '-16.5', '-68.1499', '2019-06-24 19:58:41', '2019-06-24 19:58:41', NULL),
(204, 3, '-16.5', '-68.1499', '2019-06-24 19:58:55', '2019-06-24 19:58:55', NULL),
(205, 3, '-16.5', '-68.1499', '2019-06-24 19:59:04', '2019-06-24 19:59:04', NULL),
(206, 3, '-16.5', '-68.1499', '2019-06-24 19:59:15', '2019-06-24 19:59:15', NULL),
(207, 3, '-16.5', '-68.1499', '2019-06-24 19:59:25', '2019-06-24 19:59:25', NULL),
(208, 3, '-16.5', '-68.1499', '2019-06-24 19:59:34', '2019-06-24 19:59:34', NULL),
(209, 3, '-16.5', '-68.1499', '2019-06-24 19:59:47', '2019-06-24 19:59:47', NULL),
(210, 3, '-16.5', '-68.1499', '2019-06-24 20:00:06', '2019-06-24 20:00:06', NULL),
(211, 3, '-16.5', '-68.1499', '2019-06-24 20:00:33', '2019-06-24 20:00:33', NULL),
(212, 3, '-16.5', '-68.1499', '2019-06-24 20:00:43', '2019-06-24 20:00:43', NULL),
(213, 3, '-16.5', '-68.1499', '2019-06-24 20:00:53', '2019-06-24 20:00:53', NULL),
(214, 3, '-16.5', '-68.1499', '2019-06-24 20:01:10', '2019-06-24 20:01:10', NULL),
(215, 3, '-16.5', '-68.1499', '2019-06-24 20:01:27', '2019-06-24 20:01:27', NULL),
(216, 3, '-16.5', '-68.1499', '2019-06-24 20:01:36', '2019-06-24 20:01:36', NULL),
(217, 3, '-16.5', '-68.1499', '2019-06-24 20:01:46', '2019-06-24 20:01:46', NULL),
(218, 3, '-16.5', '-68.1499', '2019-06-24 20:01:56', '2019-06-24 20:01:56', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2019-05-14 02:44:14', '2019-05-14 02:44:14'),
(2, 'user', 'Normal User', '2019-05-14 02:44:14', '2019-05-14 02:44:14'),
(3, 'encargado_pedido', 'Encargado de pedidos', '2019-06-20 03:35:30', '2019-06-20 03:35:30'),
(4, 'repartidor', 'Repartidor', '2019-06-23 00:08:12', '2019-06-23 00:09:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'empresa.title', 'Nombre de la empresa', 'Login Shop', '', 'text', 1, 'Empresa'),
(2, 'empresa.description', 'Descripción', 'Tienda en línea de Hardware', '', 'text_area', 2, 'Empresa'),
(3, 'empresa.logo', 'Logo', 'settings\\May2019\\BIm4taE5pVg5BoerNOHt.png', '', 'image', 3, 'Empresa'),
(4, 'empresa.site.google_analytics_tracking_id', 'Google Analytics Tracking ID', NULL, '', 'text', 4, 'Empresa'),
(5, 'admin.bg_image', 'Imagen de fondo', 'settings\\May2019\\Wudgw7deW8tksTadi49K.jpg', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Nombre del software', 'Fatcom', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Descripción', 'Software para administración de ventas', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Imagen de carga', 'settings\\May2019\\RvrIibvFU7FhSDX4vkYB.png', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Icono del software', 'settings\\May2019\\H1DDnGHHYiOyxrk4lVjS.png', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', NULL, '', 'text', 6, 'Admin'),
(11, 'admin.modo_sistema', 'Modo del sistema', 'restaurante', '{\r\n    \"options\":{\r\n       \"boutique\":\"Boutique\",\"repuestos\":\"Tienda de respuestos\",\"electronica_computacion\":\"Electrónica y computación\", \"restaurante\":\"Restaurante\"\r\n    }\r\n}', 'select_dropdown', 7, 'Admin'),
(12, 'admin.prefijo_codigo', 'Prefijo de código de producto', 'COD', NULL, 'text', 8, 'Admin'),
(13, 'admin.tips', 'Ayuda al usuario', '1', NULL, 'checkbox', 9, 'Admin'),
(14, 'empresa.telefono', 'Telefono', '75199157', NULL, 'text', 10, 'Empresa'),
(15, 'admin.imagen_ofertas', 'Imagen de fondo para ofertas', 'settings/June2019/YVTREo8PmW2movSJqHVr.jpg', NULL, 'image', 5, 'Admin'),
(16, 'admin.social_image', 'Imagen de fondo para compartir', 'settings/June2019/56CttKz17AstZqJZibeT.jpg', NULL, 'image', 5, 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `categoria_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `nombre`, `descripcion`, `categoria_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', 'nn', 1, '2019-05-23 18:37:01', '2019-05-23 18:37:01', NULL),
(10, 'Pizzas', NULL, 8, '2019-06-19 19:52:14', '2019-06-19 19:52:14', NULL),
(11, 'Hamburguesas', NULL, 8, '2019-06-19 19:52:55', '2019-06-19 19:52:55', NULL),
(12, 'Gaseosas', NULL, 9, '2019-06-19 19:53:44', '2019-06-19 19:53:44', NULL),
(13, 'Lomitos', NULL, 8, '2019-06-19 21:24:51', '2019-06-19 21:24:51', NULL),
(14, 'Pollos', NULL, 8, '2019-06-20 19:26:54', '2019-06-20 19:26:54', NULL),
(15, 'Carne', NULL, 8, '2019-06-20 19:27:35', '2019-06-20 19:27:35', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `latitud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `nombre`, `direccion`, `telefono`, `celular`, `created_at`, `updated_at`, `deleted_at`, `latitud`, `longitud`) VALUES
(3, 'Casa matriz', 'Calle 6 de agostos', '4623434', '75657546', '2019-05-18 21:34:13', '2019-05-20 21:57:01', NULL, '-14.846410435094622', '-64.91409301757814');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tamanio_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `nombre`, `tamanio_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', 1, '2019-05-23 18:38:38', '2019-05-23 18:38:38', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanios`
--

CREATE TABLE `tamanios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tamanios`
--

INSERT INTO `tamanios` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', 'nn', '2019-05-23 18:38:12', '2019-05-23 18:38:12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `translations`
--

INSERT INTO `translations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 'data_types', 'display_name_singular', 5, 'pt', 'Post', '2019-05-14 02:44:39', '2019-05-14 02:44:39'),
(2, 'data_types', 'display_name_singular', 6, 'pt', 'Página', '2019-05-14 02:44:39', '2019-05-14 02:44:39'),
(3, 'data_types', 'display_name_singular', 1, 'pt', 'Utilizador', '2019-05-14 02:44:39', '2019-05-14 02:44:39'),
(4, 'data_types', 'display_name_singular', 4, 'pt', 'Categoria', '2019-05-14 02:44:39', '2019-05-14 02:44:39'),
(5, 'data_types', 'display_name_singular', 2, 'pt', 'Menu', '2019-05-14 02:44:39', '2019-05-14 02:44:39'),
(6, 'data_types', 'display_name_singular', 3, 'pt', 'Função', '2019-05-14 02:44:39', '2019-05-14 02:44:39'),
(7, 'data_types', 'display_name_plural', 5, 'pt', 'Posts', '2019-05-14 02:44:40', '2019-05-14 02:44:40'),
(8, 'data_types', 'display_name_plural', 6, 'pt', 'Páginas', '2019-05-14 02:44:40', '2019-05-14 02:44:40'),
(9, 'data_types', 'display_name_plural', 1, 'pt', 'Utilizadores', '2019-05-14 02:44:40', '2019-05-14 02:44:40'),
(10, 'data_types', 'display_name_plural', 4, 'pt', 'Categorias', '2019-05-14 02:44:40', '2019-05-14 02:44:40'),
(11, 'data_types', 'display_name_plural', 2, 'pt', 'Menus', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(12, 'data_types', 'display_name_plural', 3, 'pt', 'Funções', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(13, 'categories', 'slug', 1, 'pt', 'categoria-1', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(14, 'categories', 'name', 1, 'pt', 'Categoria 1', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(15, 'categories', 'slug', 2, 'pt', 'categoria-2', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(16, 'categories', 'name', 2, 'pt', 'Categoria 2', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(17, 'pages', 'title', 1, 'pt', 'Olá Mundo', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(18, 'pages', 'slug', 1, 'pt', 'ola-mundo', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(19, 'pages', 'body', 1, 'pt', '<p>Olá Mundo. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(20, 'menu_items', 'title', 1, 'pt', 'Painel de Controle', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(21, 'menu_items', 'title', 2, 'pt', 'Media', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(22, 'menu_items', 'title', 12, 'pt', 'Publicações', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(23, 'menu_items', 'title', 3, 'pt', 'Utilizadores', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(24, 'menu_items', 'title', 11, 'pt', 'Categorias', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(25, 'menu_items', 'title', 13, 'pt', 'Páginas', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(26, 'menu_items', 'title', 4, 'pt', 'Funções', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(27, 'menu_items', 'title', 5, 'pt', 'Ferramentas', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(28, 'menu_items', 'title', 6, 'pt', 'Menus', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(29, 'menu_items', 'title', 7, 'pt', 'Base de dados', '2019-05-14 02:44:41', '2019-05-14 02:44:41'),
(30, 'menu_items', 'title', 10, 'pt', 'Configurações', '2019-05-14 02:44:41', '2019-05-14 02:44:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abreviacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`, `abreviacion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', 'df', '2019-05-23 18:37:26', '2019-05-23 18:37:26', NULL),
(2, 'Kilogramos', 'Kg.', '2019-06-15 01:41:30', '2019-06-15 01:41:57', NULL),
(3, 'Litros', 'Lt.', '2019-06-15 01:41:46', '2019-06-15 01:41:46', NULL),
(4, 'Unidades', 'Unid.', '2019-06-15 01:42:14', '2019-06-15 01:42:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@admin.com', 'users/default.png', NULL, '$2y$10$yaw1hC3ckH5TKM1yUZu2jeCCB1r8pCE.Isd6fY/Od6k5VQqRy7eVq', 'nASR9YvdaVuIc2Oag3ymJZHQJzRhNgnbaoCr6sU3LRbHBkLDblK8vlR4r4ir', NULL, '2019-05-14 02:44:34', '2019-05-14 02:44:34'),
(2, 2, 'Cliente', 'cliente@admin.com', 'users/default.png', NULL, '$2y$10$VuUkJYHt0Tq3foKXc6KdYO/01LzOFfKJdFZtHMxZYgbiiPNAzJDem', NULL, '{\"locale\":\"es\"}', '2019-05-29 01:35:08', '2019-05-29 20:36:17'),
(7, 3, 'Encargado de pedidos', 'pedidos@admin.com', 'users/default.png', NULL, '$2y$10$lT8cJT5DeuHBTP.AWS5ewOnRkPSAizxkYWPo1BLVp8AdNl0UT4ahG', NULL, '{\"locale\":\"es\"}', '2019-06-20 03:36:00', '2019-06-20 03:36:00'),
(8, 2, 'Cliente 3', 'cliente3@admin.com', 'users/default.png', NULL, '$2y$10$NWf/176YnEwYHvf1niQLKuXdjIHpdKOFlniPRjcOFgFu4Wkvus1pW', NULL, NULL, '2019-06-21 00:55:16', '2019-06-21 00:55:16'),
(9, 4, 'Repartidor', 'repartidor@admin.com', 'users/default.png', NULL, '$2y$10$lcdcETcaLyo5mk/J0EAFuuQg7GT64LK9IHPaQ9IklOqTljyjJAYIq', NULL, '{\"locale\":\"es\"}', '2019-06-23 00:08:58', '2019-06-23 00:08:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_coordenadas`
--

CREATE TABLE `users_coordenadas` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `concurrencia` int(11) DEFAULT NULL,
  `ultima_ubicacion` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users_coordenadas`
--

INSERT INTO `users_coordenadas` (`id`, `user_id`, `lat`, `lon`, `descripcion`, `concurrencia`, `ultima_ubicacion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 2, '-16.5', '-68.1499', 'Calle 18 de nov frente a la cancha', 5, NULL, '2019-06-20 20:38:32', '2019-06-22 22:44:40', NULL),
(4, 2, '-14.8376159312177', '-64.91065979003908', 'Casa color blanco con verde con porton negro Nro 123', 9, 1, '2019-06-20 21:08:03', '2019-06-22 22:44:40', NULL),
(5, 1, '-14.831642101976621', '-64.92216110229494', 'Casa amarilla con puerta roja numero 278 cerca del puente', 4, 1, '2019-06-20 22:01:34', '2019-06-21 02:59:46', NULL),
(6, 8, '-14.83861155338482', '-64.89624023437501', 'Descripcion de la ubicación', 2, 1, '2019-06-21 01:01:31', '2019-06-21 01:08:12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usos`
--

CREATE TABLE `usos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usos`
--

INSERT INTO `usos` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default', 'nn', '2019-05-23 18:39:29', '2019-05-23 18:39:29', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `nro_factura` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_control` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_autorizacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_limite` date DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `importe_ice` decimal(10,2) DEFAULT NULL,
  `importe_exento` decimal(10,2) DEFAULT NULL,
  `tasa_cero` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `importe_base` decimal(10,2) DEFAULT NULL,
  `debito_fiscal` decimal(10,2) DEFAULT NULL,
  `caja_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_estado` int(11) NOT NULL DEFAULT '1',
  `nro_mesa` int(11) DEFAULT NULL,
  `autorizacion_id` int(11) DEFAULT NULL,
  `monto_recibido` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `cliente_id`, `fecha`, `nro_factura`, `codigo_control`, `estado`, `nro_autorizacion`, `fecha_limite`, `importe`, `importe_ice`, `importe_exento`, `tasa_cero`, `subtotal`, `descuento`, `importe_base`, `debito_fiscal`, `caja_id`, `user_id`, `tipo`, `tipo_estado`, `nro_mesa`, `autorizacion_id`, `monto_recibido`, `created_at`, `updated_at`, `deleted_at`) VALUES
(40, 6, '2019-06-20', NULL, NULL, 'V', NULL, NULL, '14.00', '0.00', '0.00', '0.00', '14.00', '0.00', '14.00', '1.82', NULL, 2, 'pedido', 5, NULL, NULL, '0.00', '2019-06-20 22:23:07', '2019-06-21 00:29:39', NULL),
(48, 1, '2019-06-20', NULL, NULL, 'V', NULL, NULL, '12.00', '0.00', '0.00', '0.00', '12.00', '0.00', '12.00', '1.56', 3, 1, 'llevar', 5, NULL, NULL, '20.00', '2019-06-20 22:38:20', '2019-06-21 01:07:38', NULL),
(49, 1, '2019-06-20', NULL, NULL, 'V', NULL, NULL, '47.00', '0.00', '0.00', '0.00', '47.00', '0.00', '47.00', '6.11', 3, 1, 'llevar', 5, NULL, NULL, '50.00', '2019-06-20 22:39:48', '2019-06-21 00:28:28', NULL),
(50, 7, '2019-06-20', NULL, NULL, 'V', NULL, NULL, '40.00', '0.00', '0.00', '0.00', '40.00', '0.00', '40.00', '5.20', 3, 1, 'venta', 5, 4, NULL, '50.00', '2019-06-20 22:41:57', '2019-06-20 22:41:57', NULL),
(51, 1, '2019-06-20', NULL, NULL, 'V', NULL, NULL, '40.00', '0.00', '0.00', '0.00', '40.00', '0.00', '40.00', '5.20', 3, 1, 'llevar', 5, NULL, NULL, '60.00', '2019-06-21 00:51:21', '2019-06-21 00:51:44', NULL),
(52, 9, '2019-06-20', NULL, NULL, 'V', NULL, NULL, '7.00', '0.00', '0.00', '0.00', '7.00', '0.00', '7.00', '0.91', NULL, 8, 'pedido', 5, NULL, NULL, '0.00', '2019-06-21 01:01:31', '2019-06-21 01:07:22', NULL),
(53, 9, '2019-06-20', NULL, NULL, 'V', NULL, NULL, '36.00', '0.00', '0.00', '0.00', '36.00', '0.00', '36.00', '4.68', NULL, 8, 'pedido', 5, NULL, NULL, '0.00', '2019-06-21 01:08:12', '2019-06-21 01:08:34', NULL),
(54, 8, '2019-06-20', NULL, NULL, 'V', NULL, NULL, '36.00', '0.00', '0.00', '0.00', '36.00', '0.00', '36.00', '4.68', NULL, 1, 'pedido', 5, NULL, NULL, '0.00', '2019-06-21 02:59:46', '2019-06-22 19:23:28', NULL),
(55, 6, '2019-06-22', NULL, NULL, 'V', NULL, NULL, '7.00', '0.00', '0.00', '0.00', '7.00', '0.00', '7.00', '0.91', NULL, 2, 'pedido', 5, NULL, NULL, '0.00', '2019-06-22 19:24:12', '2019-06-22 19:24:54', NULL),
(56, 6, '2019-06-22', NULL, NULL, 'V', NULL, NULL, '7.00', '0.00', '0.00', '0.00', '7.00', '0.00', '7.00', '0.91', NULL, 2, 'pedido', 5, NULL, NULL, '0.00', '2019-06-22 19:27:04', '2019-06-22 19:28:29', NULL),
(57, 6, '2019-06-22', NULL, NULL, 'V', NULL, NULL, '7.00', '0.00', '0.00', '0.00', '7.00', '0.00', '7.00', '0.91', NULL, 2, 'pedido', 5, NULL, NULL, '0.00', '2019-06-22 19:28:46', '2019-06-22 19:31:57', NULL),
(58, 6, '2019-06-22', NULL, NULL, 'V', NULL, NULL, '36.00', '0.00', '0.00', '0.00', '36.00', '0.00', '36.00', '4.68', NULL, 2, 'pedido', 5, NULL, NULL, '0.00', '2019-06-22 19:32:46', '2019-06-22 19:34:20', NULL),
(59, 6, '2019-06-22', NULL, NULL, 'V', NULL, NULL, '36.00', '0.00', '0.00', '0.00', '36.00', '0.00', '36.00', '4.68', NULL, 2, 'pedido', 5, NULL, NULL, '0.00', '2019-06-22 19:35:58', '2019-06-22 19:37:12', NULL),
(60, 6, '2019-06-22', NULL, NULL, 'V', NULL, NULL, '15.00', '0.00', '0.00', '0.00', '15.00', '0.00', '15.00', '1.95', NULL, 2, 'pedido', 5, NULL, NULL, '0.00', '2019-06-22 19:56:17', '2019-06-22 20:41:49', NULL),
(61, 6, '2019-06-22', NULL, NULL, 'V', NULL, NULL, '7.00', '0.00', '0.00', '0.00', '7.00', '0.00', '7.00', '0.91', NULL, 2, 'pedido', 5, NULL, NULL, '0.00', '2019-06-22 21:15:12', '2019-06-22 22:44:04', NULL),
(62, 6, '2019-06-22', NULL, NULL, 'V', NULL, NULL, '63.00', '0.00', '0.00', '0.00', '63.00', '0.00', '63.00', '8.19', NULL, 2, 'pedido', 4, NULL, NULL, '0.00', '2019-06-22 22:44:40', '2019-06-22 22:51:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalles`
--

CREATE TABLE `ventas_detalles` (
  `id` int(10) UNSIGNED NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas_detalles`
--

INSERT INTO `ventas_detalles` (`id`, `venta_id`, `producto_id`, `precio`, `cantidad`, `created_at`, `updated_at`, `deleted_at`) VALUES
(26, 40, 2, '7.00', '2.00', '2019-06-20 22:23:07', '2019-06-20 22:23:07', NULL),
(27, 48, 2, '12.00', '1.00', '2019-06-20 22:38:21', '2019-06-20 22:38:21', NULL),
(28, 49, 6, '20.00', '1.00', '2019-06-20 22:39:48', '2019-06-20 22:39:48', NULL),
(29, 49, 4, '15.00', '1.00', '2019-06-20 22:39:48', '2019-06-20 22:39:48', NULL),
(30, 49, 2, '12.00', '1.00', '2019-06-20 22:39:49', '2019-06-20 22:39:49', NULL),
(31, 50, 1, '40.00', '1.00', '2019-06-20 22:41:57', '2019-06-20 22:41:57', NULL),
(32, 51, 1, '40.00', '1.00', '2019-06-21 00:51:21', '2019-06-21 00:51:21', NULL),
(33, 52, 2, '7.00', '1.00', '2019-06-21 01:01:31', '2019-06-21 01:01:31', NULL),
(34, 53, 1, '36.00', '1.00', '2019-06-21 01:08:12', '2019-06-21 01:08:12', NULL),
(35, 54, 1, '36.00', '1.00', '2019-06-21 02:59:46', '2019-06-21 02:59:46', NULL),
(36, 55, 2, '7.00', '1.00', '2019-06-22 19:24:12', '2019-06-22 19:24:12', NULL),
(37, 56, 2, '7.00', '1.00', '2019-06-22 19:27:04', '2019-06-22 19:27:04', NULL),
(38, 57, 2, '7.00', '1.00', '2019-06-22 19:28:46', '2019-06-22 19:28:46', NULL),
(39, 58, 1, '36.00', '1.00', '2019-06-22 19:32:47', '2019-06-22 19:32:47', NULL),
(40, 59, 1, '36.00', '1.00', '2019-06-22 19:35:58', '2019-06-22 19:35:58', NULL),
(41, 60, 4, '15.00', '1.00', '2019-06-22 19:56:17', '2019-06-22 19:56:17', NULL),
(42, 61, 2, '7.00', '1.00', '2019-06-22 21:15:13', '2019-06-22 21:15:13', NULL),
(43, 62, 1, '36.00', '1.00', '2019-06-22 22:44:40', '2019-06-22 22:44:40', NULL),
(44, 62, 4, '15.00', '1.00', '2019-06-22 22:44:40', '2019-06-22 22:44:40', NULL),
(45, 62, 3, '12.00', '1.00', '2019-06-22 22:44:40', '2019-06-22 22:44:40', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras_detalles`
--
ALTER TABLE `compras_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_detalles_compra_id_index` (`compra_id`);

--
-- Indices de la tabla `costo_envios`
--
ALTER TABLE `costo_envios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Indices de la tabla `data_types`
--
ALTER TABLE `data_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Indices de la tabla `depositos`
--
ALTER TABLE `depositos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `deposito_productos`
--
ALTER TABLE `deposito_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ecommerce_productos`
--
ALTER TABLE `ecommerce_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ie_asientos`
--
ALTER TABLE `ie_asientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ie_cajas`
--
ALTER TABLE `ie_cajas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indices de la tabla `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ofertas_detalles`
--
ALTER TABLE `ofertas_detalles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indices de la tabla `pasarela_pagos`
--
ALTER TABLE `pasarela_pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_key_index` (`key`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indices de la tabla `precios_compras`
--
ALTER TABLE `precios_compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos_comentarios`
--
ALTER TABLE `productos_comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos_insumos`
--
ALTER TABLE `productos_insumos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos_puntuaciones`
--
ALTER TABLE `productos_puntuaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto_unidades`
--
ALTER TABLE `producto_unidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `repartidores`
--
ALTER TABLE `repartidores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `repartidores_pedidos`
--
ALTER TABLE `repartidores_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `repartidores_ubicaciones`
--
ALTER TABLE `repartidores_ubicaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tamanios`
--
ALTER TABLE `tamanios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `users_coordenadas`
--
ALTER TABLE `users_coordenadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `user_roles_user_id_index` (`user_id`),
  ADD KEY `user_roles_role_id_index` (`role_id`);

--
-- Indices de la tabla `usos`
--
ALTER TABLE `usos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compras_detalles`
--
ALTER TABLE `compras_detalles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `costo_envios`
--
ALTER TABLE `costo_envios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT de la tabla `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `depositos`
--
ALTER TABLE `depositos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `deposito_productos`
--
ALTER TABLE `deposito_productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ecommerce_productos`
--
ALTER TABLE `ecommerce_productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ie_asientos`
--
ALTER TABLE `ie_asientos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `ie_cajas`
--
ALTER TABLE `ie_cajas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `insumos`
--
ALTER TABLE `insumos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ofertas_detalles`
--
ALTER TABLE `ofertas_detalles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pasarela_pagos`
--
ALTER TABLE `pasarela_pagos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `precios_compras`
--
ALTER TABLE `precios_compras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos_comentarios`
--
ALTER TABLE `productos_comentarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos_insumos`
--
ALTER TABLE `productos_insumos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `productos_puntuaciones`
--
ALTER TABLE `productos_puntuaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `producto_unidades`
--
ALTER TABLE `producto_unidades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `repartidores`
--
ALTER TABLE `repartidores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `repartidores_pedidos`
--
ALTER TABLE `repartidores_pedidos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `repartidores_ubicaciones`
--
ALTER TABLE `repartidores_ubicaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tamanios`
--
ALTER TABLE `tamanios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users_coordenadas`
--
ALTER TABLE `users_coordenadas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usos`
--
ALTER TABLE `usos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `data_rows`
--
ALTER TABLE `data_rows`
  ADD CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
