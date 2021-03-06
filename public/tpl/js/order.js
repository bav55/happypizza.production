$(document).ready(function () {
    var $miniCart = $('.cart-mini');

    $miniCart.on('click', function () {
        if ($miniCart.hasClass('opened')) {
            $miniCart.removeClass('opened');
        } else{
            $miniCart.addClass('opened');
        }
    });

    $('.btn-group-happypizza').on('click', '.btn', function () {
        var $this = $(this), tabId;

        $this.parent().find('.btn-active').removeClass('btn-active');
        $this.addClass('btn-active');

        if (tabId = $this.data('tab')) {
            if (tabId == 'delivery-pickup' || tabId == 'delivery-courier') {
                $('.delivery-courier').addClass('is-hidden');
                $('.delivery-pickup').addClass('is-hidden');

                $('.' + tabId).removeClass('is-hidden');
            }
        }
    });

    var $deliveryDropDown = $('.delivery-courier').find('.dropdown-menu');

    if ($deliveryDropDown.length) {
        $deliveryDropDown.find('li').click(function () {
            $deliveryDropDown.find('.selected').removeClass('selected');
            $(this).addClass('selected');
        });
    }

    $(".delivery_type_id").click(function () {
        var $button = $(this);
        var $time_div = $("#time").parent().parent();

        $("#delivery_type_id").val($(this).data("type"));

        if ($button.data("type")==2) {
            $time_div.removeClass("is-hidden");
        } else {
            $time_div.addClass("is-hidden");
        }
    });

    $(".delivery_zone_id").click(function () {
        $("#delivery_type_id").val($(this).data("type"));
    });

    $(".pay_type_id").click(function () {
        var $button = $(this);
        var $money_div = $("#money").parent().parent();

        $("#pay_type_id").val($button.data("type"));

        if ($button.data("type")==1) {
            $money_div.removeClass("is-hidden");
        } else {
            $money_div.addClass("is-hidden");
        }
    });


    function order_form_validate() {
        var error = false;
            var required = {};
            if ($('#delivery_type_id').val() != 1){
                required = {
                    name : $('#account-name'),
                    phone : $('#account-phone'),
                    /*email : $('#account-email'),*/
                    street : $('#street'),
                    house : $('#house')
                };
            } else {
                required = {
                    name : $('#account-name'),
                    phone : $('#account-phone'),
                    /*email : $('#account-email')*/
                };
            }
            $.each(required, function () {
                if (this.val() == ''){
                    this.parent().addClass('has-error');
                    error = true;
                }
            });
        return error;
    }


    $('form#order-cart').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        op_select = $('#operator-select');
        if(op_select.length > 0){
            $('#comment').val($('#comment').val()+'; '+'Заказ оформил: '+$('#operator-select option:selected').text());
        }
        var $checkoutSuccess = $('#cart-success');
        form.find('.has-error').removeClass('has-error');
        send_loader(form.find('button'));
        if (order_form_validate() == false){
            $.ajax({
                url: form.attr('action'),
                type: "post",
                data: form.serialize(),
                dataType: "json",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (val) {
                    $('#cart-success .order-id strong').html(val.order_number);
                    
                    $('#sms').load('/sms.php');
                    
                    $('#cart-success .order-time strong').html(val.pay_date);
                    
                    
                    
                    console.log('sms');
                    if((val.pay_type == 1) || (val.pay_type == 3)){
                        $checkoutSuccess.modal('show');
						sendSMS(val.sms);
                    }else if (val.pay_type == 2) {
                        payHandler(val.order_sum, val.order_id, val.email, val.order_number, val.sms);
                    }
                },
                complete:function () {
                    send_loader_error(form.find('button'));
                }
            });
        } else {send_loader_error(form.find('button'));}


        return false

    });
	
	function sendSMS(sms){
		$.ajax({
			url: sms,
			type: "GET",
			contentType: "application/json; charset=utf-8",
			header: function(){
				'Access-Control-Allow-Credentials: true',
				'Access-Control-Request-Headers: Accept, X-Requested-With'
			},
			success: function(){
				console.log('sms-sending');
			}
		});
	}

    $('#cart-success button').on('click', function () {
        window.location.replace(link);
    });


    var payHandler = function (amount,invoiceId,accountId,order_number,sms) {
        console.log('Sum_' +amount +' Order_id_' +invoiceId +' user_email_'+accountId + ' order_number_'+order_number);
console.log(sms);
var order_id = invoiceId;
        
        $('#cart-success').modal('show');
                    //sendSMS(sms);
                    $.ajax({
			url: '/sens-message-pay',
			type: "post",
			data: {order_id:order_id},
                        dataType: "json",
			headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
			success: function () {
				
			},
			complete:function () {
				//send_loader_error();
			}
			
                    });
        //требуется библиотека jquery
        var widget = new cp.CloudPayments();
        widget.charge({ // options
                publicId: 'pk_679d433a0f8cd656ed601ff66e63e',
                description: 'Оплата в заказа ' + order_number,
                amount: amount, //сумма
                currency: 'KZT',
                invoiceId: invoiceId, //номер заказа
                accountId: accountId //плательщик
            },
            function (options) { // success
                $('#cart-success').modal('show');
                    //sendSMS(sms);
                    $.ajax({
			url: '/sens-message-pay',
			type: "post",
			data: {order_id:order_id},
                        dataType: "json",
			headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
			success: function () {
				
			},
			complete:function () {
				//send_loader_error();
			}
			
                    });
                                
                                
            },
            function (reason, options) { // fail
                //действие при неуспешном платеже
            });
    };
    $("#payButton").on("click", payHandler); //кнопка "Оплатить"
});