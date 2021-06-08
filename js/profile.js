$(document).ready(function () {
    $(document).on('click','#resetpasswordbtn',function(){
        $("#resetpassword").modal("show");
    })

    $(document).on('click','#rstpassword', function(){
        var emailaddress = document.getElementById("emailaddressrst").value;
        $.ajax({
            url: "class/profile.php",
            method: "POST",
            data: { resetpassword: 1 , email: emailaddress},
            success: function(response){
                var resp = $.parseJSON(response);
                if(resp.status==999){
                    alert(resp.message);
                    $("#resetpassword").modal("hide");
                    $("#resetpassword").find("input").val("");
                }else if(resp.status==998){
                    alert(resp.message);
                }
            }
        })
    });
    function displayOrders() {
        $.ajax({
            url: "class/profile.php",
            method: "POST",
            data: { displayOrder: 1 },
            success: function (response) {
                var resp = $.parseJSON(response);
                var orderHTML = "";
                if (resp.status == 200) {
                    var orders = resp.message.orders
                    if (orders) {

                        counter = 1;
                        $.each(resp.message.orders, function (index, value) {
                            // <th scope="col">#</th>
                            // <th scope="col">Order ID</th>
                            // <th scope="col">Shipping Method</th>
                            // <th scope="col">Status</th>
                            // <th scope="col" style="max-width: 20%;">Action</th>
                            orderHTML += "<tr>";
                            orderHTML += "<th scope='row' style='padding:1rem;'>" + counter + "</th>";
                            orderHTML += "<td style='padding:1rem;'>" + value.orderid + "</td>";
                            orderHTML += "<td style='padding:1rem;'>" + value.ordertime + "</td>";
                            orderHTML += "<td style='padding:1rem;'>" + value.shippingmethod + "</td>";
                            orderHTML += "<td style='padding:1rem;'>" + value.orderstatus + "</td>";
                            orderHTML += "<td style='padding:1rem;'>";
                            orderHTML += "<button type='button' class='btn btn-primary checkorder' value='" + value.orderid + "'>Check Order<span style='display:none;'>" + JSON.stringify(value) + "</span></button>";
                            orderHTML += "</td>";
                            orderHTML += "<tr>";
                            counter++;
                        })

                        $("#ordertable").html(orderHTML);

                    }
                }
            }
        })
    }

    $(document).on('click', '.checkorder', function () {
        var order = $.parseJSON($.trim($(this).find('span').text()));
        console.log(order);
        var orderid = ($(this).val());
        $("#ordertitle").html("Order ID: " + order.orderid);
        $("#ordertime").html("Order created at: " + order.ordertime);
        $("#orderdeliverto").html("Deliver to: <br><h3 style='margin:1rem 2rem 1rem 2rem'>" + order.name + " (" + order.tel + "),<br>" + order.address + ",<br>" + order.zip + ",<br>" + order.country);

        $("#order_List").modal('show');
        $.ajax({
            url: "class/profile.php",
            method: "POST",
            data: { checkorder: 1, id: orderid },
            success: function (response) {
                // console.log(response);
                var resp = $.parseJSON(response);
                // console.log(resp.message);
                var productHTML = "";
                if (resp.status == 201) {
                    var orderProduct = resp.message.productList;
                    if (orderProduct) {

                        $.each(resp.message.productList, function (index, value) {
                            // <tr style="color: gray; font-size:smaller   ">
                            //     <th style="width: 16rem;"><small>PRODUCT DETAILS</small></th>
                            //     <th style="width: 16rem;"><small>QUANTITY</small></th>
                            //     <th><small>PRICE</small></th>
                            //     <th><small>TOTAL</small></th>
                            // </tr>
                            productHTML += `<tr>
                            <td style='width:16rem;'>
                                    <img src='admin/productimage/`+ value.picture + `' style='width:100px; height:100px;' alt=''>
                                    <p style='margin-bottom:0; font-size:10px'>`+ value.pname + `</p>
                             </td>
                            <td style='vertical-align: middle; text-align:center;'>
                                `+ value.quantity + `
                            </td>
                                    <td style='vertical-align: middle; text-align:center;'>RM `+ value.pprice + `</td>
                                    <td style='vertical-align: middle; text-align:center;'>RM `+ roundToTwo(value.pprice, value.quantity).toFixed(2) + `</td>
                            </tr>`;

                        })
                        $("#orderproductlist").html(productHTML);
                    }
                }
            }
        })
    })
    function roundToTwo(a, b) {
        var num = a * b;
        return +(Math.round(num + "e+2") + "e-2");
    }

    $(document).on('click', '#addnewcardbtn', function () {
        var nameoncard = document.getElementById("nameoncard").value;
        var cardnumber1 = document.getElementById("cardnumber1").value;
        var cardnumber2 = document.getElementById("cardnumber2").value;
        var cardnumber3 = document.getElementById("cardnumber3").value;
        var cardnumber4 = document.getElementById("cardnumber4").value;
        var expirydate = document.getElementById("expirydate").value;
        var cvv = document.getElementById("cvv").value;

        console.log(cardnumber);
        if (!nameoncard || !cardnumber1 || !cardnumber2 || !cardnumber3 || !cardnumber4 || !expirydate || !cvv) {
            alert("Empty Field(s)!");
        } else {
            var cardnumber = cardnumber1 + cardnumber2 + cardnumber3 + cardnumber4;
            if (cardnumber.length != 16) {
                alert("Invalid card");
            } else {
                $.ajax({
                    url: "class/profile.php",
                    method: "POST",
                    data: ({
                        addnewcard: 1, name: nameoncard, cardnum: cardnumber, expirydate: expirydate, cvv: cvv
                    }),
                    success: function (response) {
                        var resp = $.parseJSON(response);
                        if(resp.status==202){
                            alert(resp.message);
                            $("#exampleModal").modal("hide");
                            displayCard();
                        }
                        
                    }
                })
            }

        }
    })

    function displayCard(){
        $.ajax({
            url: "class/profile.php",
            method: "POST",
            data: ({
                displaycard: 1
            }),
            success: function(response){
                var resp = $.parseJSON(response);
                var cardHTML = "";
                
                if(resp.status==204){
                    cardHTML = "<div style='text-align:center;'><span>You do not have any card.</span></div>";
                    $("#cardcontainer").html(cardHTML);
                }else if (resp.status==203){
                    // console.log(123);
                    var cardList = resp.message.cardList;
                    if(cardList){
                        if(cardList.length>0){
                            $.each(resp.message.cardList, function(index,value){
                                cardHTML += "<div class='cardrow' style='display: flex; margin: 20px; padding: 4rem; background-color:#f8f8f8;'>";
                                cardHTML += "<div class='col1' style='flex: 20%; margin:auto;'>";
                                cardHTML += "<img style='float:left;' src='images/visa.png'>"
                                if(value.defaultcard==1){
                                    cardHTML += "<p style='text-align:left;margin-bottom:0; color: green; padding-left:15rem;'><strong>default<strong></p>"
                                }
                                cardHTML += "</div>";

                                cardHTML += "<div class='col2' style='flex:40%; margin:auto;'>";
                                var mask="";
                                var counter=0;
                                for(var i=0; i<value.cardnumber.length-4; i++){
                                    mask+="<i class='fas fa-star-of-life'></i>";
                                    counter++;
                                    if(counter==4){
                                        mask+='<i class="fas fa-minus"></i>';
                                        counter=0;
                                    }
                                }
                                for (var i=value.cardnumber.length-4;i<value.cardnumber.length; i++){
                                    mask+= value.cardnumber[i];
                                }
                                cardHTML += mask +"</div>";
                                cardHTML += "<div class='col3' style='flex:6%; margin:auto;'>";
                                
    
                                if(value.defaultcard==0){
                                    cardHTML += "<button class='deletecard' value='"+value.paymentid+"' style='padding: 0.5rem; background-color:transparent;'>Delete</button>"
                                    cardHTML += "<button class='defaultcard' value='"+value.paymentid+"' style='padding: 0.5rem; background-color:transparent;'>Set as default</button>";
                                }else if (value.defaultcard==1){
                                    cardHTML += "<button class='deletecard' value='"+value.paymentid+"' style='padding: 0.5rem; background-color:transparent;' disabled>Delete</button>"
                                    cardHTML += "<button class='defaultcard' value='"+value.paymentid+"' style='padding: 0.5rem; background-color:transparent;' disabled>Set as default</button>"
                                }
                                cardHTML += "</div></div>";
                            })
                        }
                        $("#cardcontainer").html(cardHTML);
                    }
                }
            }
        })
    }

    $(document).on('click','.deletecard',function(){
        var paymentid = $(this).val();
        console.log(paymentid);
        if(confirm("Do you want to delete this card?")){
            $.ajax({
                url: 'class/profile.php',
                method: 'POST',
                data: ({
                    deletecard:1, payid: paymentid
                }),success: function(response){
                    var resp = $.parseJSON(response);
                    if(resp.status==205){
                        alert(resp.message);   
                        displayCard(); 
                    }else{
                        alert(resp.message);
                    }
                }
            })
        }
    });
    $(document).on('click','.defaultcard',function(){
        var paymentid = $(this).val();
        if(confirm("Do you want to set this as your default card?")){
            $.ajax({
                url: 'class/profile.php',
                method: 'POST',
                data: ({
                    defaultcard:1, payid: paymentid
                }),success: function(response){
                    var resp = $.parseJSON(response);
                    if(resp.status==206){
                        alert(resp.message);   
                        displayCard(); 
                    }else{
                        alert(resp.message);
                    }
                }
            })
        }
    });

    function displayAddress(){
        $.ajax({
            url:"class/profile.php",
            method:"POST",
            data: ({
                displayaddress:1
            }),success: function(response){
                var resp = $.parseJSON(response);
                var addressHTML = "";
                if(resp.status==208){
                    addressHTML ="<div style='text-align:center;'><span>You do not have any address.</span></div>";
                    $("#addresscontainer").html(addressHTML);
                    console.log(resp.message);
                }else if(resp.status==207){
                    var addressList = resp.message.addressList;
                    if(addressList){
                        $.each(resp.message.addressList, function(index,value){
                            addressHTML += "<div style='margin: 20px; background-color:#f8f8f8'>";
                            addressHTML +=      "<div style='margin: 20px; background-color:#f8f8f8'>";
                            addressHTML +=              "<div class='addressrow' style='display:flex'>";
                            addressHTML +=                      "<div style='text-align:right; padding: 1rem; flex:25%'>";
                            addressHTML +=                              "<span style='color: gray;'>Full name: <br>";
                            addressHTML +=                                  "<p style='font-size:small ;'> Phone Number: <br> Address:</p>";
                            addressHTML +=                              "</span>";
                            addressHTML +=                      "</div>";
                            addressHTML +=                      "<div style='text-align:left; padding: 1rem; flex: 50%'>";
                            addressHTML +=                          "<strong>"+value.name+"</strong>";
                            if(value.defaultaddress==1){
                                addressHTML += "<small style='font-weight:bold; margin-left:2rem; color:green;'>default</small>";
                            }
                            addressHTML +=                          "<br><p style='font-size:small ;'>"+value.tel+"<br>";
                            addressHTML +=                              value.address+"<br>";
                            addressHTML +=                              value.zip+"<br>";
                            addressHTML +=                             value.country+"<br></p>";
                            addressHTML +=                      "</div>";
                            addressHTML +=                      "<div style='flex:25%; padding: 1rem; width: 100%; text-align:right; margin:auto;'>";
                            if(value.defaultaddress==1){
                                addressHTML +=                          "<button class='deleteaddress' value='"+value.addressid+"' style='padding:0.5rem;' disabled>Delete</button>";
                                addressHTML +=                          "<button class='defaultaddress' value='"+value.addressid+"' disabled>Set as default</button>";
                            }else{
                                addressHTML +=                          "<button class='deleteaddress' value='"+value.addressid+"' style='padding:0.5rem;'>Delete</button>";
                                addressHTML +=                          "<button class='defaultaddress' value='"+value.addressid+"'>Set as default</button>";   
                            }
                            addressHTML +=                      "</div>";
                            addressHTML +=              "</div>";
                            addressHTML +=      "</div>";
                            addressHTML += "</div>";
                        })
                        $("#addresscontainer").html(addressHTML);
                    }
                }
            }
        });
    }
    $(document).on('click','.deleteaddress', function(){
        var addressid = $(this).val();
        console.log(addressid);
        if(confirm("Do you want to delete this address?")){
            $.ajax({
                url: 'class/profile.php',
                method: 'POST',
                data: ({
                    deleteaddress:1, addressid: addressid
                }),success: function(response){
                    var resp = $.parseJSON(response);
                    if(resp.status==210){
                        alert(resp.message);   
                        displayAddress(); 
                    }else{
                        // alert(resp.message);
                    }
                }
            })
        }
    });

    $(document).on('click','.defaultaddress', function(){
        var addressid = $(this).val();
        if(confirm("Do you want to set this as your default address?")){
            $.ajax({
                url: 'class/profile.php',
                method: 'POST',
                data: ({
                    defaultaddress:1, aid: addressid
                }),success: function(response){
                    // alert(response);
                    var resp = $.parseJSON(response);
                    if(resp.status==211){
                        alert(resp.message);   
                        displayAddress  (); 
                    }else{
                        alert(resp.message);
                    }
                }
            })
        }
    });
    $(document).on('click','#addnewaddressbtn', function(){
        var name = document.getElementById("name").value;
        var address = document.getElementById("address").value;
        var zip = document.getElementById("zip").value;
        var country = document.getElementById("country").value;
        var phonenumber = document.getElementById("phonenumber").value;
        
        if(!name || !address || !zip || !country || !phonenumber){
            alert("Empty Fields!");

        }else{
            $.ajax({
                url: "class/profile.php",
                method: "POST",
                data: ({
                    addnewaddress:1, name:name, address:address, zip:zip, country:country, phonenumber:phonenumber
                }),success: function(response){
                    var resp = $.parseJSON(response);
                    if(resp.status==209){
                        $("#exampleModal").modal("hide");
                        alert(resp.message);
                        displayAddress();
                    }
                }
            })
        }
    })

    $(document).on('click','#submitfeedbackbtn',function(){
        var name = document.getElementById("namefb").value;
        var email = document.getElementById("emailfb").value;
        var tel = document.getElementById("phonenumfb").value;
        var message = document.getElementById("messagefb").value;
        var feeling = $("input[name=emoji]:checked").val();
        console.log(name+email+tel+message+feeling);
        $.ajax({
            url: "class/profile.php",
            method: "POST",
            data: ({
                submitfeedback:1, namefb:name, emailfb:email, telfb:tel, messagefb:message, feelingfb: feeling
            }), success: function(response){
                var resp = $.parseJSON(response);
                if(resp.status==212){
                    alert(resp.message);
                    $("#contact").find("input, textarea").each(function(){
                        $(this).val("");
                    });
                }
            }
        })
    })
    displayAddress();
    displayCard();
    displayOrders();
});