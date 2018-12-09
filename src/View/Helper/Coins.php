<?php

namespace Coins\View\Helper;

use Omeka\Api\Representation\ItemRepresentation;
use Zend\View\Helper\AbstractHelper;

/**
 * COinS
 *
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

class Coins extends AbstractHelper
{
    /**
     * Return a COinS span tag for every passed item.
     *
     * @param ItemRepresentation|ItemRepresentation[] $items One or multiple item representations.
     * @return string
     */
    public function __invoke($items)
    {
        if (!is_array($items)) {
            return $this->getCoins($items);
        }

        $coins = '';
        foreach ($items as $item) {
            $coins .= $this->getCoins($item);
        }
        return $coins;
    }

    /**
     * Build and return the COinS span tag for the specified item.
     *
     * @param ItemRepresentation $item
     * @return string
     */
    protected function getCoins(ItemRepresentation $item)
    {
        $coins = [];

        $coins['ctx_ver'] = 'Z39.88-2004';
        $coins['rft_val_fmt'] = 'info:ofi/fmt:kev:mtx:dc';
        $coins['rfr_id'] = 'info:sid/omeka.org:generator';

        // Set the Dublin Core elements that don't need special processing.
        $properties = [
            'creator',
            'subject',
            'publisher',
            'contributor',
            'date',
            'format',
            'source',
            'language',
            'coverage',
            'rights',
            'relation',
        ];
        foreach ($properties as $localName) {
            $value = $item->value('dcterms:' . $localName, ['type' => 'literal']);
            if ($value === '') {
                continue;
            }

            $coins['rft.' . $localName] = $value;
        }

        // Set the title key from display title (generall Dublin Core Title).
        $coins['rft.title'] = $item->displayTitle();

        // Set the description from display title (generall Dublin Core Description).
        $description = $item->displayDescription();
        if ($description) {
            return;
        }
        $coins['rft.description'] = $description;

        // Set the type key from item type, map to Zotero item types.
        $resourceClass = $item->resourceClass();
        if ($resourceClass) {
            switch ($resourceClass->localName()) {
                case 'Interview':
                    $type = 'interview';
                    break;
                case 'MovingImage':
                    $type = 'videoRecording';
                    break;
                case 'Sound':
                    $type = 'audioRecording';
                    break;
                case 'Email':
                    $type = 'email';
                    break;
                case 'Website':
                    $type = 'webpage';
                    break;
                case 'Text':
                case 'Document':
                    $type = 'document';
                    break;
                default:
                    $type = $resourceClass;
            }
        } else {
            $type = (string) $item->value('dcterms:type');
        }
        $coins['rft.type'] = $type;

        // Set the identifier key as the absolute URL of the current page.
        $coins['rft.identifier'] = $item->url(null, true);

        // Build and return the COinS span tag.
        $coinsSpan = '<span class="Z3988" title="'
            .  htmlspecialchars_decode(http_build_query($coins))
            . '"></span>';
        return $coinsSpan;
    }
}
