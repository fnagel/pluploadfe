mod.wizards.newContentElement.wizardItems.plugins {
	elements.pluploadfe {
		iconIdentifier = extensions-pluploadfe-wizard
		title = LLL:EXT:pluploadfe/locallang.xml:pi1_title
		description = LLL:EXT:pluploadfe/locallang.xml:pi1_plus_wiz_description
		tt_content_defValues.CType = list
		tt_content_defValues.list_type = pluploadfe_pi1
	}

	show := addToList(pluploadfe)
}