<?php

namespace Drupal\html_formatter\Plugin;

use Drupal\Core\Field\FieldItemListInterface;

trait HtmlFormatterTrait {

  /**
   * Gets the default settings for the html formatter.
   *
   * @return array
   */
  public static function getHtmlFormatterDefaultSettings() {
    return [
      'tag' => '',
      'class' => '',
      'link' => FALSE,
    ];
  }

  /**
   * Get form elements for the html formatter.
   *
   * @return array $elements
   */
  public function getHtmlFormatterSettingsForm() {
    $elements = [];
    $elements['tag'] = [
      '#type' => 'textfield',
      '#title' => t('HTML Tag'),
      '#default_value' => $this->getSetting('tag'),
      '#min' => 1,
      '#description' => t('HTML tags like: h2, div, article, etc..'),
    ];

    $elements['class'] = [
      '#type' => 'textfield',
      '#title' => t('Class Name'),
      '#default_value' => $this->getSetting('class'),
      '#min' => 1,
      '#description' => t('If left blank no class will be added.'),
    ];

    $elements['link'] = [
      '#type' => 'checkbox',
      '#title' => t('Link to Content'),
      '#default_value' => $this->getSetting('link'),
    ];

    return $elements;
  }

  /**
   * Get summary for html formatter.
   *
   * @return array
   */
  public function getHtmlFormatterSettingsSummary($settings) {
    $summary = [];

    if (!empty($settings['tag'])) {
      $summary[] = t('Rendered with HTML tag: @tag', array('@tag' => $settings['tag']));
    }

    if (!empty($settings['class'])) {
      $summary[] = t('With class: @class', array('@class' => $settings['class']));
    }

    if (!empty($settings['link'])) {
      $summary[] = t('Linked to Content');
    }

    return $summary;
  }

  /**
   * Get url from entity.
   *
   * @param FieldItemListInterface $items
   *   FieldItemListInterface items.
   *
   * @return string $url
   *   Entity url or blank if none.
   */
  public function getEntityUrl(FieldItemListInterface $items) {
    $url = '';
    $entity = $items->getEntity();
    if (!$entity->isNew()) {
      $url = $entity->urlInfo();
    }

    return $url;
  }

  /**
   * If the field formatter is set to link to content, add a link.
   *
   * @param array $settings
   *   Settings array.
   * @param string $value
   *   The value that will be printed.
   * @param string $url
   *   The url to the content.
   *
   * @return string $value
   *   The value that will be printed.
   */
  public function getLinkedValue($settings, $value, $url = '') {
    if ($settings['link'] && $url) {
      $value = [
        '#theme' => 'link_formatter_link_separate',
        '#url_title' => $value,
        '#url' => $url,
      ];
    }

    return $value;
  }

}
