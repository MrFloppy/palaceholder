<?php

/*
 * Global config values for class image
 * 
 * @author Maximilian Sohrt
 * @version 0.8
 * @todo - Exception Handling and type-checking
 */

/**
 * Enables logging if set to true
 */
define("LOGGING", true);

/**
 * Define your font here! Do not forget to put in the right folder
 */
define("FONT", "fonts/roboto/RobotoCondensed-Bold.ttf");

/**
 * Letter taken to calulate width of text
 * Should be the biggest letter from your font
 */
define("CALCULATION_LETTER", "W");

/**
 * Defines the maximum width the text is allowed to take
 * This value is for calculation, so results may not be exact
 */
define("TEXT_WIDTH_PERCENTAGE",80);

/**
 * Maximum height a text is allowed to take
 */
define("TEXT_HEIGHT_PERCENTAGE", 30);

/**
 * Use static font size instead of dynamic calculated
 */
define("STATIC_FONT_SIZE", false);

/**
 * Fallback font size or font size if static font size is active
 */
define("DEFAULT_FONT_SIZE", 10);

/**
 * Defines the path to logfile
 */
define("LOGPATH", "palaceholder.log");

define("MAX_WIDTH", 2000);

define("MAX_HEIGHT", 2000);

define("FONT_COLOR", "#FFFFFF");
?>
