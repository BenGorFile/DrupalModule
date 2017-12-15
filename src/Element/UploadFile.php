<?php

/*
 * This file is part of the BenGorFile package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Drupal\bengor_file\Element;

use Drupal\Core\Render\Annotation\FormElement;
use Drupal\Core\Render\Element\File;

/**
 * @FormElement("upload_file")
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class UploadFile extends File
{
    public function getInfo()
    {
        return [
            '#input'          => true,
            '#pre_render'     => [
                [
                    UploadFile::class,
                    'preRenderFile',
                ],
            ],
            '#theme'          => 'upload_file',
            '#theme_wrappers' => [
                'form_element',
            ],
        ];
    }

    public static function preRenderFile($element) : array
    {
        $element = parent::preRenderFile($element);

        $element['#url'] = isset($element['#value']) && $element['#value']
            ? self::buildUrlFromFile(self::fileOfId($element['#value']))
            : null;

        return $element;
    }

    private static function buildUrlFromFile(array $file) : ?string
    {
        if (empty($file)) {
            return null;
        }

        return \file_create_url('public://uploads/' . $file['file_name']);
    }

    private static function fileOfId(string $id) : array
    {
        return \Drupal::getContainer()->get('bengor_file.http.file_of_id')->fileOfId($id);
    }
}
