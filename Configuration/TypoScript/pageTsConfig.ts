mod.wizards.newContentElement.wizardItems.plugins {
	elements.pluploadfe {
		iconIdentifier = extensions-pluploadfe-wizard
		# Fallback for TYPO3 6.2
		icon = ../typo3conf/ext/pluploadfe/Resources/Public/Icons/ce_wiz.gif
		title = LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:pi1_title
		description = LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:pi1_plus_wiz_description
		tt_content_defValues.CType = list
		tt_content_defValues.list_type = pluploadfe_pi1
	}

	show := addToList(pluploadfe)
}