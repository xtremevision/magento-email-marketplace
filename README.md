# magento-email-marketplace

This module is the original Emag Marketplace developed by Zitec, updated to support latest version of Magento 2 and PHP.

Change Log:

14/03/2026 - Fixed the PHP 8 deprecation caused by an optional parameter appearing before required parameters:

CategoryMappingRepositoryInterface.php (line 30)
CategoryMappingRepository.php (line 92)
MappingManager.php (line 95)
Save.php (line 76)

What changed:

Reordered save() method signatures so required params come first and optional $id comes last.
Updated the internal call chain to use the new argument order.
Normalized the controller’s request id handling so new records pass null instead of 0.
Tightened the repository check from truthy $id to explicit $id !== null so update/create behavior stays correct.
Update composer.json and module.xml to version 1.0.3
