
$(document).ready(function () {


    var productList, brandList, productdetailList, chgbrand = true, filter = "", page = 0;
    // var filter = ["", "", "", "", ""];
    var url_string = window.location.href;
    var url = new URL(url_string);
    var c = url.searchParams.get("pid");
    var category = url.searchParams.get("category");
    var subcategory = url.searchParams.get("subcategory");
    var brand = url.searchParams.get("brand");
    var search = "";
    var productidforshoppinglist;
    var quantityforshoppinglist;
    $("#categorybtn").click(function () {
        document.getElementById("dropdowncategory").classList.toggle("tap");
        $("i", this).toggleClass("fa-chevron-up fa-chevron-down");
    });
    // $(document).on('click', '.brandbtn', function () {
    //     filter[1] = $(this).val();
    //     displayFilteredProductList();
    // });

    $(document).on('input', '#form1', function () {
        // console.log(document.getElementById("form1").value);
        search = document.getElementById("form1").value
        displayProduct();
    })

    $(document).on('click', '.catbtn', function () {
        $(".catbtn.active").toggleClass("active");
        $(this).toggleClass("active");
    });

    // $(document).on('input','#form1',function(){
    //     console.log($(this).value);
    // })

    $(document).on('change', '#shippingmethod', function () {
        getCost();
    });

    $(document).on('click', '.filter', function () {
        filter = $(this).val();
        displayProduct();
        $(".filter.active").toggleClass("active");
        $(this).toggleClass("active");
    });

    $(document).on('click', '.pagination', function () {
        page = parseInt($(this).val());
        displayProduct();
    });

    $(document).on('click', '#resetbtn', function () {
        filter = "";
        displayProduct();
    });
    function displayProduct() {
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: {
                page: page,
                filter: filter,
                cat: category,
                subcat: subcategory,
                br: brand,
                srch: search
            },
            success: function (response) {

                var resp = $.parseJSON(response);
                productList = resp.message.products;
                productRow = resp.message.numofresult;
                numoftotalresults = productRow.length;
                console.log(response);
                var productHTML = '';
                var page = '';
                productList = resp.message.products;
                if (productList) {
                    counter = 0;
                    numofrow = productList.length;
                    $.each(resp.message.products, function (index, value) {
                        if (counter == 0) {
                            productHTML += "<div class='row'>";
                        }
                        productHTML += "<div class='col-sm shadow' style='text-align:center;'>" +
                            "<a href='productdetail.php?pid=" + value.pid + "'><img src='admin/productimage/" + value.picture + "' alt=''></a>" +
                            "<div class='productinfo'>" +
                            "<h4>" + value.pname + "</h4>" +
                            "<p>RM " + parseFloat(value.pprice).toFixed(2) + "</p>" +
                            "</div>" +
                            "<div class='productbtn'>" +
                            "<button class='addbtn'><i class='fas fa-plus'></i></button>" +
                            "<input style='margin: 0 0.5rem 0 0.5rem' type='number' id='quantity" + value.pid + "' max='99' maxlength='2' value='1' oninput='javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);'>" +
                            "<button class='minusbtn'><i class='fas fa-minus'></i></button>" +

                            "<div style='margin-top: 1rem;'>" +
                            "<button style='margin-right:0.5rem' value='" + value.pid + "' class='addtocartbutton'>Add to cart&nbsp;&nbsp;&nbsp;<i class='fas fa-cart-plus'></i></button>" +
                            "<button class='addtolistbtn'  value='" + value.pid + "'><i class='fas fa-heart'></i></i></button>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                        counter++;
                        numofrow--;
                        if (counter == 3 || numofrow == 0) {
                            productHTML += "</div>";
                            counter = 0;
                        }
                    });
                    page += "<ul style='text-align: center;'>";
                    for (var i = 0; i < Math.ceil(numoftotalresults / 9); i++) {
                        page += "<li style='display: inline-block;margin: 0 10px;'><button class='pagination' value='" + i + "'>" + (i + 1) + "</button></li>";
                    }
                    page += "</ul>";
                    console.log(page);
                    $("#productlist").html(productHTML);

                    $("#pagenum").html(page);
                }
            }
        })
    }

    $(document).on('click', '.removecart', function () {
        var cartid = $(this).val();
        removeCart(cartid);
    });


    function removeCart(cartid) {
        if (confirm("Delete this from your cart?")) {
            $.ajax({
                url: "class/product.php",
                method: "POST",
                data: { deletecart: 1, cart: cartid },
                success: function (response) {
                    var resp = $.parseJSON(response);
                    displayCart();
                }
            })

        }
    }


    $(document).on('click', '.minusbtn', function () {
        $button = $(this);
        var oldval = $button.parent().find("input").val();
        if (oldval > 1) {
            var newval = parseInt(oldval) - 1;
        } else {
            var newval = 1;
        }
        $button.parent().find("input").val(newval);
    });

    $(document).on('click', '.addbtn', function () {
        $button = $(this);
        var oldval = $button.parent().find("input").val();
        if (oldval < 99) {
            var newval = parseInt(oldval) + 1;
        } else {
            var newval = 99;
        }
        $button.parent().find("input").val(newval);
    });

    $(document).on('click', '.minuscartbtn', function () {
        var cartid = $(this).val();
        var oldval = parseInt(document.getElementById("" + cartid).innerHTML);
        if (oldval > 1) {
            var newval = parseInt(oldval) - 1;
        } else {
            removeCart(cartid);
        }

        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: { updateCart: 1, cart: cartid, quantity: newval },
            success: function (response) {
                var resp = $.parseJSON(response);
            }
        })
        displayCart();
    });

    $(document).on('click', '.addcartbtn', function () {
        var cartid = $(this).val();
        var oldval = parseInt(document.getElementById("" + cartid).innerHTML);
        if (oldval < 99) {
            var newval = parseInt(oldval) + 1;
        } else {
            var newval = 99;
        }
        document.getElementById("" + cartid).innerHTML = newval;
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: { updateCart: 1, cart: cartid, quantity: newval },
            success: function (response) {
                var resp = $.parseJSON(response);
            }
        })
        displayCart();
    });

    $(document).on('click', '.addtocartbtn', function () {
        var pid = $(this).val();
        var num = document.getElementById("pquantity").value;
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: { addtocart: 1, productid: pid, quantity: num },
            success: function (response) {
                var resp = $.parseJSON(response);
                if (resp.status == 104) {
                    alert(resp.message);
                } else {
                    // alert(resp.message);
                }
            }
        })
    });

    $(document).on('click', '.addtocartbutton', function () {
        var pid = $(this).val();
        var num = document.getElementById("quantity" + pid).value;
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: { addtocart: 1, productid: pid, quantity: num },
            success: function (response) {
                var resp = $.parseJSON(response);
                if (resp.status == 104) {
                    alert(resp.message);
                } else {
                    // alert(resp.message);

                }
            }
        })
    });
    function getCost() {
        var shippingcost = ship.shippingmethod[ship.shippingmethod.selectedIndex].value;
        if (shippingcost == 0) {
            $("#shippingcost").html((4.5).toFixed(2));
        } else if (shippingcost == 1) {
            $("#shippingcost").html((0.5).toFixed(2));
        }
        var totalcost = parseFloat(document.getElementById("subtotalcost").textContent) + parseFloat(document.getElementById("shippingcost").textContent);
        $("#totalpayment").html(parseFloat(totalcost).toFixed(2));
    }


    function displayProductDetails() {
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: { productdetails_id: c },
            success: function (response) {
                var resp = $.parseJSON(response);

                if (resp.status == 103) {
                    var productdetailHTML = "";
                    var commentHTML = "";

                    var image = "";

                    productdetailList = resp.message.productdetails;
                    var comments = resp.message.comments;
                    if (productdetailList) {
                        $.each(resp.message.productdetails, function (index, value) {
                            image = "<img class='shadow' style='height:540px; width:540px; margin:0 0 3rem 5rem;' src='admin/productimage/" + value.picture + "' alt=''>";
                            productdetailHTML += "<p style='color:gray'><a href='product.php?category=" + value.parentcatid + "'>" + value.parentcat + "</a> > <a href='product.php?category=" + value.parentcatid + "&subcategory=" + value.catid + "'>" + value.cat + "</a></p><br>" +
                                "<h1 style='font-size:5rem;'>" + value.pname + "</h1>" +
                                "<div class='star-ratings-css'>";
                            var percentage = 0;

                            if (value.numofreviews == 0) {
                                percentage = 0;
                            } else {
                                percentage = (value.sumofreviews / value.numofreviews) / 5 * 100;
                            }

                            productdetailHTML += "<div class='star-ratings-css-top' style='width:" + percentage + "%'><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>" +
                                "<div class='star-ratings-css-bottom'><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>" +
                                "</div>" +
                                "<p style='margin: 1rem 0 3rem 0; font-size:smaller'>(" + value.numofreviews + " customer reviews)</p>" +
                                "<h2>RM" + value.pprice + "</h2>" +
                                "<p style='margin: 0 0 1rem 0'>Remaining stock: " + value.pquantity + "</p>";
                            if (value.pdescription == "") {
                            }
                            else {
                                productdetailHTML += "<h5 style='text-decoration: underline;'><strong>Product Description</strong></h5>" +
                                    "<div style='padding-right: 2rem;'>" + value.pdescription + "</div>";
                            }
                            productdetailHTML += "<hr>" +
                                "<h5><strong>Category: <a>" + value.cat + "</a></strong></h5>" +
                                "<h5><strong>Brand: <a>" + value.brand + "</a></strong></h5>" +
                                "<br>" +
                                `<button class='addbtn'><i class='fas fa-plus'></i></button>
                                                <input type='number' id='pquantity' max='99' maxlength='2' value='1' oninput='javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);'>
                                                <button class='minusbtn'><i class='fas fa-minus'></i></button>
                                                <div style='margin-top: 1rem;'>
                                                    <button value='`+ c + `' class='addtocartbtn'>Add to cart&nbsp;&nbsp;&nbsp;<i class='fas fa-cart-plus'></i></button>
                                                    <button class="addtolistbtn1" value="`+ c + `"><i class='fas fa-heart'></i></i></button>
                                                </div>`;
                        });
                        console.log(comments);
                        if (comments) {
                            if (comments.length == 0) {
                                console.log(456);
                                commentHTML += `<h4><strong>REVIEWS</strong></h4>`;
                                commentHTML += `Come be the first person to review this product!`;
                            } else {
                                commentHTML += `<h4><strong>REVIEWS</strong></h4>`;

                                $.each(resp.message.comments, function (index, value1) {
                                    commentHTML += "<div class='comment' style='padding: 1rem 0 2rem 0; position:relative'>";
                                    commentHTML += "<div style='display:inline-block;vertical-align:top; margin-right:20px;'>";
                                    commentHTML += "<img src='images/tacc1157_05_faceright_10k_rgb.jpeg' style='width: 60px; height:60px; border-radius:50%;' alt=''>";
                                    commentHTML += "</div>";
                                    commentHTML += "<div style='display:inline-block; max-width:570px'>";
                                    commentHTML += "<div class='star-ratings-css comment'>";
                                    commentHTML += "<div class='star-ratings-css-top' style='width:" + value1.rate / 5 * 100 + "%'><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>";
                                    commentHTML += "<div class='star-ratings-css-bottom'><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>";
                                    commentHTML += "</div>";
                                    commentHTML += "<p>" + value1.message + "</p>";
                                    commentHTML += "</div>";
                                    commentHTML += "<div style='display:inline-block; width:49rem; text-align:right; position:absolute; top:1rem; right:1rem'>";
                                    commentHTML += "<p style='font-size: 1.2rem;'><strong>" + value1.firstname + " " + value1.lastname + "</strong><span style='color: gray;'>--<em>`+value.rateat+`</em></span></p>";
                                    commentHTML += "</div></div>";
                                })
                            }



                        } else if (comments.length == 0) {

                        }


                        $("#commentsection").html(commentHTML);
                        $("#productbox").html(productdetailHTML);
                        $("#imagebox").html(image);
                    }

                }
            }
        });

    }

    function displayCart() {

        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: { displayCart: 1 },
            success: function (response) {
                var resp = $.parseJSON(response);
                if (resp.status == 105) {
                    var cartHTML = '';

                    cartList = resp.message.cart;
                    if (cartList) {
                        var total = 0
                        $.each(resp.message.cart, function (index, value) {
                            total += parseFloat(roundToTwo(value.totalcost).toFixed(2));
                            cartHTML += `<tr>
                            <td style='vertical-align: middle; width:35rem;'>
                                <div style='display:inline-block; border:1px solid;'>
                                    <img src='admin/productimage/`+ value.picture + `' style='width:100px; height:100px;' alt=''>
                                </div>
                                <div style='display:inline-block; vertical-align:middle;position:relative;text-overflow: ellipsis; overflow:hidden;white-space: nowrap; max-width:200px' class="ellipsis">

                                    <p style='margin-bottom:0;'><strong>`+ value.pname + `</strong></p>
                                    <p style='margin-bottom:0;'><small>`+ value.cat + `</small></p>
                                    <button class='removecart' value='`+ value.cartid + `' style='padding:0;'><small>x</small></button>
                                </div>
                             </td>
                                <td style='vertical-align: middle;width: 16rem;'>
                                    <form style='text-align:center; margin:auto'>
                                        <div>
                                            <button type='button' class='addcartbtn' value='`+ value.cartid + `'><i class='fas fa-plus'></i></button>
                                            <span class='quantity' id='`+ value.cartid + `'>` + value.quantity + `</span>
                                                <button type='button' class='minuscartbtn' value='`+ value.cartid + `'><i class='fas fa-minus'></i></button>
                                                                    </div>
                                                                </form>
                                                            </td>
                                    <td style='vertical-align: middle; text-align:center;'>`+ value.pprice + `</td>
                                    <td style='vertical-align: middle; text-align:center;'>`+ roundToTwo(value.totalcost).toFixed(2) + `</td>
                                                        </tr>`;
                        });
                        $("#cartlist").html(cartHTML);
                        $(".numberofitems").html(cartList.length + " item(s)")
                        $("#totalcost").html("RM " + roundToTwo(total).toFixed(2));
                        $("#subtotalcost").html(roundToTwo(total).toFixed(2));
                        getCost();
                    }

                }
            }
        });
    }
    function roundToTwo(num) {
        return +(Math.round(num + "e+2") + "e-2");
    }

    $("#changeaddressbtn").click(function () {
        document.getElementById("addressedit").classList.toggle("show");
        document.getElementById("addressdefault").classList.toggle("show");

        //   $("i", this).toggleClass("fa-chevron-up fa-chevron-down");
    });
    $("#submitaddressbtn").click(function () {
        document.getElementById("addressedit").classList.toggle("show");
        document.getElementById("addressdefault").classList.toggle("show");

        var id = $('input[name=selectaddress]:checked').val();
        $.ajax({
            method: "POST",
            url: "changeaddress.php",
            data: ({
                addressid: id
            }),
            dataType: "html",
            success: function (data) {
                $("#addressdisplay").html(data);
                // alert(data);
            }
        });
    });

    $("#canceladdressbtn").click(function () {
        document.getElementById("addressedit").classList.toggle("show");
        document.getElementById("addressdefault").classList.toggle("show");
        // alert("CANCEL");
    });

    $(document).on('click', '#placeorder', function () {
        var addressid = $('input[name=selectaddress]:checked').val();
        var paymentid = $("#paymentid").val();
        var shippingvia = ship.shippingmethod[ship.shippingmethod.selectedIndex].value;
        var totalCost = document.getElementById("totalpayment").textContent;
        $.ajax({
            type: "POST",
            url: "class/product.php",
            data: ({
                address: addressid,
                payment: paymentid,
                shipping: shippingvia,
                total: totalCost
            }),
            success: function (response) {
                var resp = $.parseJSON(response);
                if (resp.status == 109) {
                    alert(resp.message);
                    window.location.href = 'order.php';
                }
            }
        });

    });

    function displayShoppingList() {
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: ({ displayminishoppinglist: 1 }),
            success: function (response) {
                var resp = $.parseJSON(response);
                if (resp.status == 110) {
                    var shoppinglistHTML = "";
                    var shoppinglistHTML1 = "";
                    var shoppinglist = resp.message.shoppinglist;
                    var shoppinglistdetails = resp.message.shoppinglistdetails;

                    if (shoppinglist) {
                        $.each(resp.message.shoppinglist, function (index, value) {
                            shoppinglistHTML += "<tr class='shadow-sm'>";
                            shoppinglistHTML += "<td style='width: 10%;'><button class='addtoshoppinglist' value='" + value.sid + "' >+</button></td>";
                            shoppinglistHTML += "<td>" + value.shoppinglist + "</td>";
                            shoppinglistHTML += "<td style='width: 10%;'><button class='seemorelist' value='" + value.sid + "' >...</button></td>";
                            shoppinglistHTML += "</tr>";
                            shoppinglistHTML += "<tr><td colspan=3 ><div class='minishoppinglistdetails' id='minilist" + value.sid + "' style='display:none;'>";

                            shoppinglistHTML1 += "<tr class='shadow-sm' style='background-color:#f3f3f3'>";
                            shoppinglistHTML1 += "<td style='width: 10%;'><button class='expandlist' value='" + value.sid + "' ><i class='fas fa-chevron-down'></i></button></td>";
                            shoppinglistHTML1 += "<td>" + value.shoppinglist + "</td>";
                            shoppinglistHTML1 += "<td style='width: 10%;'><button class='deleteshoppinglist' value='" + value.sid + "' ><i class='fas fa-trash'></i></button></td>";
                            shoppinglistHTML1 += "</tr>";
                            shoppinglistHTML1 += "<tr><td colspan=3><div class='listdetails' id='list" + value.sid + "' style='display:none;    '>";



                            if (value.count >= 1) {
                                shoppinglistHTML1 += "<div class='row'>"
                                shoppinglistHTML1 += "<div class='col-7' style='text-align:center; color: gray;ext-align: center;font-weight: bold;'>Product Details</div>";
                                shoppinglistHTML1 += "<div class='col-2' style='text-align:center; color: gray;ext-align: center;font-weight: bold;'>Quantity</div>";
                                shoppinglistHTML1 += "<div class='col-2' style='text-align:center; color: gray;ext-align: center;font-weight: bold;'>Unit Price</div>";
                                shoppinglistHTML1 += "<div class='col-1'></div>";
                                shoppinglistHTML1 += "</div>";
                                $.each(resp.message.shoppinglistdetails, function (index, value1) {
                                    // console.log(value1);
                                    if (value.shoppinglistid == value1.shoppinglistid) {
                                        shoppinglistHTML += "";
                                        shoppinglistHTML += "<img style='height:60px; width:60px;' src='admin/productimage/" + value1.picture + "' alt=''>";
                                        // console.log("<img style='height:60px; width:60px;' src='admin/productimage/" + value1.picture + "' alt=''>");
                                        shoppinglistHTML += value1.pname + " x " + value1.quantity + "<br>";

                                        shoppinglistHTML1 += "<div class='row'>";
                                        shoppinglistHTML1 += "<div class='col-1' style='display: flex; align-items:center;'><span><button class='deletefromshoppinglist' value='" + value1.sdetailsid + "'>x</button></span></div>";
                                        shoppinglistHTML1 += "<div class='col-6' style='display: flex; align-items:center;'><img style='height:100px; width:100px; float:left;' src='admin/productimage/" + value1.picture + "'><span style='padding-left:1rem'>" + value1.pname + "<br>ABC</span></div>";
                                        shoppinglistHTML1 += "<div class='col-2' style='display: flex; justify-content:center; align-items:center'>";
                                        shoppinglistHTML1 += "<input class='inputshoppinglist' style='margin: 0 0.5rem 0 0.5rem; height:3rem' type='number' id='" + value1.sdetailsid + "' max='99' min='0' maxlength='2' value='" + value1.quantity + "' oninput='javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);'>";
                                        shoppinglistHTML1 += "</div>";
                                        shoppinglistHTML1 += "<div class='col-2' style='display: flex; justify-content:center; align-items:center'>RM " + value1.pprice + "</div>";
                                        shoppinglistHTML1 += "<div class='col-1' style='display: flex; justify-content:center; align-items:center'><button class='addtocartfromshoppinglist' value='" + value1.sdetailsid + "'><span>" + `<i class="fas fa-cart-plus"></i>` + "</span><button></div>";
                                        shoppinglistHTML1 += "</div>";
                                    }
                                });
                                shoppinglistHTML1 += "<div class='row'>";
                                shoppinglistHTML1 += "<div class='col-10'></div>";
                                shoppinglistHTML1 += "<div class='col-2' style='display: flex; justify-content:center; align-items:center; background-color: rgba(237, 171, 161);'><button class='addalltocart' value='" + value.sid + "'>ADD ALL TO CART  " + `<i class="fas fa-cart-plus"></i>` + "</button></div>";
                                shoppinglistHTML1 += "</div>";
                                shoppinglistHTML1 += "</div></td></tr>";
                            } else {
                                shoppinglistHTML += "Empty List...";
                                shoppinglistHTML1 += "EMpty...";
                            }
                            shoppinglistHTML += "</div></td></tr>";


                        });
                        // console.log(shoppinglistHTML);
                        $("#shoppinglistmodal").html(shoppinglistHTML);
                        $("#shoppinglistpage").html(shoppinglistHTML1);
                    }
                }
            }
        })
    }

    $(document).on('click', '#addshoppinglistbtn', function () {
        var shoppinglist = document.getElementById("shoppinglistname").value;
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: ({ addnewshoppinglist: 1, shoplist: shoppinglist }),
            success: function (response) {
                console.log(response);
                var resp = $.parseJSON(response);
                if (resp.status == 111) {
                    alert(resp.message);
                    displayShoppingList();
                    document.getElementById("shoppinglistname").value = "";
                }
            }
        })
    });
    $(document).on('click', '.addtolistbtn', function () {
        $('#shoppinglist').modal("show");
        productidforshoppinglist = $(this).val(); //initialize
        quantityforshoppinglist = document.getElementById("quantity" + productidforshoppinglist).value;
        // console.log(quantityforshoppinglist)
    });
    $(document).on('click', '.addtolistbtn1', function () {
        $('#shoppinglist').modal("show");
        productidforshoppinglist = $(this).val(); //initialize
        quantityforshoppinglist = document.getElementById("pquantity").value;
        // console.log(quantityforshoppinglist)
    });

    $(document).on('click', '.addtoshoppinglist', function () {
        // alert(productidforshoppinglist);
        var shoppinglistid = $(this).val();
        // alert(shoppinglistid);
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: ({ addtoshoppinglist: 1, pid: productidforshoppinglist, sid: shoppinglistid, quantity: quantityforshoppinglist }),
            success: function (response) {
                // console.log(response);
                var resp = $.parseJSON(response);
                if (resp.status == 112) {
                    alert(resp.message);
                    $('#shoppinglist').modal("hide");
                    displayShoppingList();
                }
            }
        });
    });

    $(document).on('click', '.seemorelist', function () {
        var shoppinglistid1 = $(this).val();
        // alert(shoppinglistid1);
        var elems = document.getElementsByClassName('minishoppinglistdetails');
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'none';
        }
        $("#minilist" + shoppinglistid1).css("display", "table-cell");
    })

    $(document).on('input', '.inputshoppinglist', function () {
        var inputid = $(this).attr("id");
        var val = $(this).val();
        if (!val) {
            $(this).val(1);
        }
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: ({
                updatelist: 1, sdetailid: inputid, quantity: val
            }),
            success: function (response) {
                var resp = $.parseJSON(response);
                if (resp.status == 113) {
                    console.log(resp.message);
                } else {
                    console.log("PROBLEM!");
                }
            }
        })

    });
    $(document).on('change', '.inputshoppinglist', function () {
        var val = $(this).val();
        var inputid = $(this).attr("id");
        if (!val) {

        }
    })
    $(document).on('click', '.deletefromshoppinglist', function () {
        // alert($(this).val());
        var sdetailsid = $(this).val();
        if (confirm("Do you want to delete this product from the list?")) {
            $.ajax({
                url: "class/product.php",
                method: "POST",
                data: ({
                    deletefromshoppinglist: 1, sdetailid: sdetailsid
                }),
                success: function (response) {
                    var resp = $.parseJSON(response);
                    if (resp.status == 114) {
                        console.log(resp.message);
                        displayShoppingList();
                    } else {
                        console.log("PROBLEM!");
                    }
                }
            })
        }
    })

    $(document).on('click', '.addtocartfromshoppinglist', function () {
        var sdetailsid = $(this).val();
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: ({
                addtocartfromshoppinglist: 1, sdetailid: sdetailsid
            }),
            success: function (response) {
                var resp = $.parseJSON(response);
                if (resp.status == 115) {
                    alert(resp.message);
                } else {
                    console.log("PROBLEM!");
                }
            }
        })
    })

    $(document).on('click', '.addalltocart', function () {
        var shoppinglistid = $(this).val();
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: ({
                addalltocart: 1, shoppinglistid: shoppinglistid
            }),
            success: function (response) {
                var resp = $.parseJSON(response);
                if (resp.status == 116) {
                    alert(resp.message);
                } else {
                    console.log("PROBLEM");
                }
            }
        })
    })
    $(document).on('click', '.deleteshoppinglist', function () {
        var shoppinglistid = $(this).val();
        if (confirm("Do you want to delete this list?")) {
            $.ajax({
                url: "class/product.php",
                method: "POST",
                data: ({
                    deleteshoppinglist: 1, shoppinglistid: shoppinglistid
                }),
                success: function (response) {
                    var resp = $.parseJSON(response);
                    if (resp.status == 117) {
                        displayShoppingList();
                        alert(resp.message);

                    } else {
                        console.log("PROBLEM");
                    }
                }
            })
        }
    })

    $(document).on('click', '.expandlist', function () {
        var shoppinglistid1 = $(this).val();
        var elems = document.getElementsByClassName("listdetails");
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'none';
        }
        $("#list" + shoppinglistid1).css("display", "block");

    })

    $(document).on('click', '#addnewshoppinglistbtn', function () {
        // alert(123);
        $("#exampleModal").modal("show");
    })

    $(document).on('click', '#submitreviewbtn', function () {
        var pid = $(this).val();
        var review = $("input[name='rating3']:checked").val();
        var comment = document.getElementById("commentforreview").value;
        console.log(comment);
        $.ajax({
            url: "class/product.php",
            method: "POST",
            data: ({
                submitreview: 1, productid: pid, star: review, message: comment
            }),
            success: function (response) {
                var resp = $.parseJSON(response);
                if (resp.status == 118) {
                    alert(resp.message);
                    displayProductDetails();
                }
            }

        })
    })

    
    displayCart();
    displayProductDetails();
    // displayProductList();

    displayShoppingList();
});
