$(function() {
  $.getJSON('accounts.php',
    function(data) {
      $.each(data.accounts, function() {
        $('#account').append('<option>' + this.account + '</option>')
        if (this.name == $('#current_account').val()) {
          $('#account option:last').attr('selected', 'selected');
        }
      });

      $('#account').change();
    }
  );

  $('#account').change(function() {
    $.getJSON('currencies.php',
      { account: $('#account').val() },
      function(data) {
        $.each(data.currencies, function() {
          $('#currency').append('<option>' + this.name + '</option>')
          if (this.name == $('#current_currency').val()) {
            $('#currency option:last').attr('selected', 'selected');
          }
        });

        $('#currency').change();
      }
    );
  });

  $('#currency').change(function() {
    $('tbody tr').not(':first').remove();
    $.getJSON('transactions.php',
      { trading_account: $('#account').val(), currency: $('#currency').val() },
      function(data) {
        $.each(data.transactions, function() {
          var keys = Object.keys(this);
          var transaction = this;
          $('tbody:first').append('<tr><td></td><td></td><td></td><td></td><td></td></tr>')

          $.each(keys, function(i,v) {
            $('tbody tr:last td:eq(' + i + ')').html(transaction[v]);
          });
        });
      }
    );
  });

});
