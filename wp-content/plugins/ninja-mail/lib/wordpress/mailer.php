<?php

namespace NinjaMail\WordPress;

/**
 * An interface for decorating phpMailer.
 */
interface Mailer
{
  public function send();
}
