<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
$_EXTKEY = 'ns_ext_compatibility';

    if (TYPO3_MODE === 'BE') {
        /**
         * Registers a Backend Module
         */
        if (version_compare(TYPO3_branch, '11.0', '<')) {
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'NITSAN.' . $_EXTKEY,
                'tools',	 // Make module a submodule of 'tools'
                'nsextcompatibility',	// Submodule key
                '',						// Position
                [
                    'nsextcompatibility' => 'list,viewAllVersion,detail,updateExtensionList'
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/ns_ext_compatibility.svg',
                    'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:module.title',
                ]
            );
        } else {
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'NsExtCompatibility',
                'tools',	 // Make module a submodule of 'tools'
                'nsextcompatibility',	// Submodule key
                '',						// Position
                [
                    \NITSAN\NsExtCompatibility\Controller\nsextcompatibilityController::class => 'list,viewAllVersion,detail,updateExtensionList'
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/ns_ext_compatibility.svg',
                    'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:module.title',
                ]
            );
        }

        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['NITSAN\\NsExtCompatibility\\Task\\SendExtensionsReportTask'] =[
        'extension' => $_EXTKEY,
        'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.sendExtensionsReportTask.title',
        'description' => 'LLL:EXT:pb_check_extensions/Resources/Private/Language/locallang.xlf:task.sendReport.description',
        'additionalFields' => 'NITSAN\\NsExtCompatibility\\Task\\SendExtensionsReportTaskAdditionalFieldProvider'
        ];
    }
    if (version_compare(TYPO3_branch, '6.2', '<')) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/nsextcompatibility6/6.1', 'ns_ext_compatibility');
    } elseif (version_compare(TYPO3_branch, '7.0', '<')) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/nsextcompatibility6/6.2', 'ns_ext_compatibility');
    } else {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'ns_ext_compatibility');
    }
