=== Sync orders with Xero from WooCommerce - Xelation ===

Contributors: glidedigital
Donate link: https://xelation.org/#pricing-plans
Tags: xero, woocommerce xero, connect xero, woocommerce xero sync, sync xero
Requires at least: 4.0
Tested up to: 6.6.2
Stable tag: 0.1.2
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically sync your WooCommerce orders with Xero along with payments, contacts & inventory.

== Description ==

Xelation seamlessly synchronizes your WooCommerce orders with Xero in real-time.

Automatically sync invoices with Xero with your preferred account mappings for sales, shipping, payments & transaction fees across multiple stores, currencies & tax jurisdictions.


== Features ==

Core features:

* sync WooCommerce invoices with Xero as either *Draft, Submitted, Authorised* or *Paid*
* map shipping costs to corresponding revenue account
* map payments to corresponding bank account
* set payments to automatically reconcile with the bank statement
* map *Stripe/PayPal* transaction fees to preferred cost accounts (rendered as a separate *purchase bill*)
* map product tax rate to corresponding Xero tax rate for the relevant tax jurisdiction e.g. *standard, zero-rated, exempt, inclusive, exclusive,* etc.
* configure order status that triggers sync with Xero e.g. *pending, processing, completed* or combination thereof

Further features:

* automatically sync incoming order items with Xero *products & services*
* sync WooCommerce inventory with Xero inventory
* sync customers details to Xero *contacts*
* generate WooCommerce *order note* alongside order with deep link back to invoice in Xero
* in the case of 'pay later' invoices; apply payments to pre-existing invoice in Xero
* sync past orders; just let us know how far back you would like to go
* map preferred *tracking category* to line item
* map preferred *branding theme* template to invoice
* append custom prefix to invoice number
* ...and much more!


== The Pitch! ==

* Free 14 day trial!
* Start synching invoices in less than a minute!
* Simply connect to Xero and configure your mappings

...then watch your invoices sail into Xero!

== Typical Business Scenario ==

A typical client scenario is where:

* a WooCommerce order needs to be rendered as a sales invoice in Xero with its line items and shipping costs mapped to the corresponding revenue accounts and tax rate in Xero
* the transaction fee needs to be rendered as a purchase bill in the costs account e.g. COGS
* the captured payment needs to be mapped to the corresponding bank account in Xero
* the payment needs to be reconciled with the bank statement feed

You can also:

* determine when WooCommerce orders are pushed to Xero i.e. **Processing, Completed** or **Pending** status
* determine the status of Xero invoices i.e. **Draft, Submitted, Authorised** or **Paid**
* set your preferred **invoice prefix** e.g. **Web**004567
* **deep link** between your WooCommerce **Order Notes** and the generated Xero invoice in either direction allowing you to quickly toggle between the two platforms
* enable the **stock control** feature which will automatically synchronize your WooCommerce inventory with the *quantity to hand* set in Xero

== Installation ==

1. Install the Xelation plugin either via the WordPress plugin directory, or by uploading the files to your web server (in the /wp-content/plugins/ directory).
2. Activate the Xelation plugin through the 'Plugins' menu in WordPress.
3. Navigate to the 'Settings > Xelation' page to connect to Xero and start configuring your mappings, triggers and stock control.

If you have an issue or question while setting up or using the plugin then please submit a support ticket to [support@xelation.org](mailto:support@xelation.org) and we'll get back to you as soon as we can.

== Use of 3rd Parties ==

Please note this plugin requires the use of 3rd party services:

* [Xero](https://xero.com/)
* [Xelation](https://xelation.org/)

By allowing access to Xero, you agree to the transfer of your data between Xero and Xelation in accordance with Xero's [terms of use](https://www.xero.com/uk/legal/terms/) and Xelation's [terms of use](https://xelation.org/terms) and [privacy policy](https://xelation.org/privacy-policy).

You can disconnect Xero from the live Xelation service at any time by clicking the **Disconnect from Xero** button.

You can fully disconnect the Xelation app from Xero at any time under the **Connected apps** section of your Xero settings.

== Requirements ==

* [WooCommerce plugin](https://wordpress.org/plugins/woocommerce/)
* [Xero instance](https://xero.com/)

== De-activate plugin ==

To de-activate the plugin:

1. Click the **Disconnect from WooCoomerce** button
2. De-activate the plugin

== Uninstall ==

To completely uninstall the plugin:

1. Click the **Disconnect from WooCoomerce** button
2. De-activate the plugin
3. Manually remove Xelation webhooks under: WooCoomerce > Settings > Advanced > Webhooks
3. Manually remove Xelation API keys under: WooCoomerce > Settings > Advanced > REST API

== Frequently Asked Questions ==

Consult our comprehensive FAQs on our [website](https://xelation.org/#faqs).

== Support ==

Please email us at info@xelation.org if you have any questions or need help.

== Changelog ==

= 0.1 =
* Initial release.

= 0.1.1 =
* Dependencies check.

= 0.1.2 =
* Improve auto-refresh of gateway page so connection statii are more tightly synced.
* Add support for multiple stores.

== Screenshots ==

TBC

== Upgrade Notice ==

TBC