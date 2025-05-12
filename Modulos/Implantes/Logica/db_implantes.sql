-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-08-2024 a las 19:10:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_implantes`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultar_casaComercial` ()   BEGIN
    SELECT id_casa_comer,nombre_casaComer 
    FROM tbl_casa_comercial
    ORDER BY nombre_casaComer; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Consultar_tipo_implante` ()   BEGIN
    SELECT id_tipo_implante, nombre_implante 
    FROM tbl_tipos_implantes
    ORDER BY nombre_implante;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ingresar_Registro_Implantes_Pacientes` (IN `p_Episodio` INT, IN `p_NumeroIdentificacion` INT, IN `p_NumeroInternoPaciente` INT, IN `p_NombrePaciente` VARCHAR(200), IN `p_Aseguradora` VARCHAR(200), IN `p_NombreCirujano` VARCHAR(200), IN `p_Especialidad` VARCHAR(100), IN `p_FechaCirugia` DATE, IN `p_Observaciones` VARCHAR(255), IN `p_CasaComercial` INT, IN `p_IdImplante` INT, IN `p_EntrenamientoSoport` VARCHAR(2), IN `p_TiempoSoporte` VARCHAR(2), IN `p_Material` VARCHAR(2), IN `p_Falla` VARCHAR(2), IN `p_ImplTiempoCorpaul` VARCHAR(2), IN `p_ImplCompletoCorpaul` VARCHAR(2), IN `p_Diagnostico` VARCHAR(300))   BEGIN
    DECLARE v_idPaciente INT;

    -- Insertar en `tbl_implantes`
    INSERT INTO tbl_implantes (
        Episodio, Numero_identificacion, Numero_interno_paciente, Nombre_paciente,
        Aseguradora, Nombre_cirujano, Especialidad, fecha_cirugía, Observaciones
    ) VALUES (
        p_Episodio, p_NumeroIdentificacion, p_NumeroInternoPaciente, p_NombrePaciente,
        p_Aseguradora, p_NombreCirujano, p_Especialidad, p_FechaCirugia, p_Observaciones
    );

    -- Obtener el ID del paciente insertado
    SET v_idPaciente = LAST_INSERT_ID();

    -- Insertar en `tbl_implantes_detalles`
    INSERT INTO tbl_implantes_detalles (
        Id_paciente, Id_casa_Comercial, Id_implante, entrenamiento_Soport,
        tiempo_Soporte, material_complet, falla_implant_cx, impl_tiempo_corpaul,
        impl_completo_corpaul
    ) VALUES (
        v_idPaciente, p_CasaComercial, p_IdImplante, p_EntrenamientoSoport,
        p_TiempoSoporte, p_Material, p_Falla, p_ImplTiempoCorpaul,
        p_ImplCompletoCorpaul
    );

    -- Insertar en `tbl_diagnosticos_pacientes`
    INSERT INTO tbl_diagnosticos_pacientes (
        Id_paciente, diagnosticos
    ) VALUES (
        v_idPaciente, p_Diagnostico
    );
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_casa_comercial`
--

CREATE TABLE `tbl_casa_comercial` (
  `id_casa_comer` int(11) NOT NULL,
  `nombre_casaComer` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_casa_comercial`
--

INSERT INTO `tbl_casa_comercial` (`id_casa_comer`, `nombre_casaComer`) VALUES
(1, 'AMAREY NOVA MEDICAL S.A.'),
(2, 'AVALON PHARMACEUTICAL S.A.'),
(3, 'B.BRAUN MEDICAL S.A.'),
(4, 'B.H. SALUD S.A.'),
(5, 'BIOART S.A'),
(6, 'BONETECH S.A.S'),
(7, 'DISORTHO S.A.'),
(8, 'DISTRIBUCIONES PT S.A.S'),
(9, 'DIVERQUIN S.A.S.'),
(10, 'EDM EQUIPOS Y DISPOSITIVOS MEDICOS S.A.S'),
(11, 'FUNDACION ORGANIZACION VID'),
(12, 'GIL MEDICA S.A.'),
(13, 'HOSPIMPORT S.A.'),
(14, 'IDEAS MEDICAS S.A.S'),
(15, 'IMPLANTECH LTDA'),
(16, 'IMPLANTES Y SISTEMAS ORTOPEDICOS S.A'),
(17, 'INBIOS S.A.S'),
(18, 'INDUSTRIAS MEDICAS SAMPEDRO S.A.S.'),
(19, 'IVAN PADILLA DENTAL CORPORATION S.A.S'),
(20, 'JOHNSON JOHNSON DE COLOMBIA S.A'),
(21, 'LA INSTRUMENTADORA S.A.S'),
(22, 'LH S.A.S'),
(23, 'MEDIHUMANA COLOMBIA S.A.'),
(24, 'MEDINISTROS S.A.S'),
(25, 'MEDIREX S.A.S'),
(26, 'MEDITECX SAS'),
(27, 'MEDTRONIC COLOMBIA SA'),
(28, 'OSEOMED S.A.S'),
(29, 'OSTEOMEDICAL S.A.S'),
(30, 'QUIRURGICOS LTDA.'),
(31, 'R.P. DENTAL S.A'),
(32, 'SMITH NEPHEW COLOMBIA S.A.S'),
(33, 'SUMINEURO S.A.S'),
(34, 'SUPLEMEDICOS S.A.S.'),
(35, 'W LORENZ S.A.S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_diagnosticos_pacientes`
--

CREATE TABLE `tbl_diagnosticos_pacientes` (
  `Id_diagnostico` int(11) NOT NULL,
  `Id_paciente` int(11) NOT NULL,
  `diagnosticos` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_diagnosticos_pacientes`
--

INSERT INTO `tbl_diagnosticos_pacientes` (`Id_diagnostico`, `Id_paciente`, `diagnosticos`) VALUES
(15, 39, 'prueba 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_implantes`
--

CREATE TABLE `tbl_implantes` (
  `Id_paciente` int(11) NOT NULL,
  `Episodio` int(11) NOT NULL,
  `Numero_identificacion` int(30) NOT NULL,
  `Numero_interno_paciente` int(11) NOT NULL,
  `Nombre_paciente` varchar(200) NOT NULL,
  `Aseguradora` varchar(200) NOT NULL,
  `Nombre_cirujano` varchar(200) NOT NULL,
  `Especialidad` varchar(100) NOT NULL,
  `fecha_cirugía` date NOT NULL,
  `Observaciones` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_implantes`
--

INSERT INTO `tbl_implantes` (`Id_paciente`, `Episodio`, `Numero_identificacion`, `Numero_interno_paciente`, `Nombre_paciente`, `Aseguradora`, `Nombre_cirujano`, `Especialidad`, `fecha_cirugía`, `Observaciones`) VALUES
(39, 4608396, 71083126, 1581211, 'EVELIO DE JESUS FLOREZ CHAVERRA', 'COOSALUD ENTIDAD PROMOTORA DE SALUD', '1', '1', '2024-08-14', 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_implantes_detalles`
--

CREATE TABLE `tbl_implantes_detalles` (
  `id_detalle_implante` int(11) NOT NULL,
  `Id_paciente` int(11) NOT NULL,
  `Id_casa_Comercial` int(11) NOT NULL,
  `Id_implante` int(11) NOT NULL,
  `entrenamiento_Soport` varchar(2) NOT NULL,
  `tiempo_Soporte` varchar(2) NOT NULL,
  `material_complet` varchar(2) NOT NULL,
  `falla_implant_cx` varchar(2) NOT NULL,
  `impl_tiempo_corpaul` varchar(2) NOT NULL,
  `impl_completo_corpaul` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_implantes_detalles`
--

INSERT INTO `tbl_implantes_detalles` (`id_detalle_implante`, `Id_paciente`, `Id_casa_Comercial`, `Id_implante`, `entrenamiento_Soport`, `tiempo_Soporte`, `material_complet`, `falla_implant_cx`, `impl_tiempo_corpaul`, `impl_completo_corpaul`) VALUES
(26, 39, 5, 5, 'No', 'si', 'si', 'no', 'si', 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipos_implantes`
--

CREATE TABLE `tbl_tipos_implantes` (
  `id_tipo_implante` int(11) NOT NULL,
  `nombre_implante` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_tipos_implantes`
--

INSERT INTO `tbl_tipos_implantes` (`id_tipo_implante`, `nombre_implante`) VALUES
(4, 'Tipo implante 1'),
(5, 'Tipo implante 2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_casa_comercial`
--
ALTER TABLE `tbl_casa_comercial`
  ADD PRIMARY KEY (`id_casa_comer`);

--
-- Indices de la tabla `tbl_diagnosticos_pacientes`
--
ALTER TABLE `tbl_diagnosticos_pacientes`
  ADD PRIMARY KEY (`Id_diagnostico`),
  ADD KEY `Id_paciente` (`Id_paciente`);

--
-- Indices de la tabla `tbl_implantes`
--
ALTER TABLE `tbl_implantes`
  ADD PRIMARY KEY (`Id_paciente`);

--
-- Indices de la tabla `tbl_implantes_detalles`
--
ALTER TABLE `tbl_implantes_detalles`
  ADD PRIMARY KEY (`id_detalle_implante`),
  ADD KEY `fk_id_casaComercial` (`Id_casa_Comercial`),
  ADD KEY `Id_implante` (`Id_implante`),
  ADD KEY `Id_paciente` (`Id_paciente`);

--
-- Indices de la tabla `tbl_tipos_implantes`
--
ALTER TABLE `tbl_tipos_implantes`
  ADD PRIMARY KEY (`id_tipo_implante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_casa_comercial`
--
ALTER TABLE `tbl_casa_comercial`
  MODIFY `id_casa_comer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `tbl_diagnosticos_pacientes`
--
ALTER TABLE `tbl_diagnosticos_pacientes`
  MODIFY `Id_diagnostico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_implantes`
--
ALTER TABLE `tbl_implantes`
  MODIFY `Id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `tbl_implantes_detalles`
--
ALTER TABLE `tbl_implantes_detalles`
  MODIFY `id_detalle_implante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tbl_tipos_implantes`
--
ALTER TABLE `tbl_tipos_implantes`
  MODIFY `id_tipo_implante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_diagnosticos_pacientes`
--
ALTER TABLE `tbl_diagnosticos_pacientes`
  ADD CONSTRAINT `tbl_diagnosticos_pacientes_ibfk_1` FOREIGN KEY (`Id_paciente`) REFERENCES `tbl_implantes` (`Id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_implantes_detalles`
--
ALTER TABLE `tbl_implantes_detalles`
  ADD CONSTRAINT `fk_id_casaComercial` FOREIGN KEY (`Id_casa_Comercial`) REFERENCES `tbl_casa_comercial` (`id_casa_comer`),
  ADD CONSTRAINT `tbl_implantes_detalles_ibfk_1` FOREIGN KEY (`Id_implante`) REFERENCES `tbl_tipos_implantes` (`id_tipo_implante`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_implantes_detalles_ibfk_2` FOREIGN KEY (`Id_paciente`) REFERENCES `tbl_implantes` (`Id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
