$(function() {
  $.getJSON('transactions.php',
    { trading_account: $('#trading_account').val(), currency: $('#currency').val() },
    function(data) {
      $.each(data.transactions, function() {
        var keys = Object.keys(this);
        var transaction = this;

        $.each(keys, function(i,v) {
          $('tbody tr:last td:eq(' + i + ')').html(transaction[v]);
        });

        $('tbody:last').append($('tbody tr:last').clone());
      });

      $('tbody tr:last').remove();
    }
  );
});
