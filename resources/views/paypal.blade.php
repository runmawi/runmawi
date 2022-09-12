<div id="paypal-button-container-P-6XA79361YH9914942MMPN3BQ"></div>
<script src="https://www.paypal.com/sdk/js?client-id=AVGcAgzu_FN6jiaO8AAqyaXxFPeVfWMBG9OK2CJbnbgqDpnAsNqEpOQ12-Sor5eK0NRduzL4RddazjoV&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
<script>
  paypal.Buttons({
      style: {
          shape: 'pill',
          color: 'white',
          layout: 'vertical',
          label: 'subscribe'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: 'P-6XA79361YH9914942MMPN3BQ'
        });
      },
      onApprove: function(data, actions) {
        alert(data.subscriptionID); // You can add optional success message for the subscriber here
      }
  }).render('#paypal-button-container-P-6XA79361YH9914942MMPN3BQ'); // Renders the PayPal button
</script>	