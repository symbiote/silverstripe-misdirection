<?php

namespace nglasl\misdirection;

use SilverStripe\Core\Extension;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\View\Requirements;

/**
 *	This extension adds the testing interface used to view the link mapping recursion stack.
 *	@author Nathan Glasl <nathan@symbiote.com.au>
 */

class MisdirectionAdminTestingExtension extends Extension
{

    /**
     *	Update the edit form to include the URL input and test button.
     */

    public function updateEditForm($form)
    {

        Requirements::css('nglasl/silverstripe-misdirection: client/css/misdirection.css');

        // Restrict this functionality to administrators.

        $user = Member::currentUserID();
        if(Permission::checkMember($user, 'ADMIN')) {
            $gridfield = $form->fields->items[0];
            if(isset($gridfield)) {

                // Add the required HTML fragment.

                Requirements::javascript('nglasl/silverstripe-misdirection: client/javascript/misdirection-testing.js');
                $configuration = $gridfield->config;
                $configuration->addComponent(new MisdirectionTesting());
            }
        }

        // Allow extension customisation.

        $this->owner->extend('updateMisdirectionAdminTestingExtensionEditForm', $form);
    }

}
