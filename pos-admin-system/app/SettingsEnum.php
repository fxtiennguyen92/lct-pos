<?php

namespace App;

enum SettingsEnum: string
{
    
    case EC_TAX_DEFAULT = 'ecommerce_default_tax_rate';
    case EC_PRICE_INCLUDING_TAX = 'ecommerce_display_price_including_tax';
    
}
