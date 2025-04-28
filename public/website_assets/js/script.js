$(document).ready(function () {

    var rtl = false;

    if ($("html").attr("dir") == 'rtl') {
        rtl = true;
        $('body').addClass('rtl-style');
    }

    /* Header Fixed */

    $(window).scroll(function () {

        if ($(window).scrollTop() >= 100) {
            $('#header').addClass('fixed-header');
        } else {
            $('#header').removeClass('fixed-header');
        }

    });


    /* Hamburger */

    $(".hamburger").click(function () {
        $(".aside-menu").addClass('active');
        $("body").addClass('active');
    });

    $(".close-menu").click(function () {
        $(".aside-menu").removeClass('active');
        $("body").removeClass('active');
    });

    $(".btnReg").click(function (e) {
        e.preventDefault();
    });

    $('.search-mobile').on('click', function() {
        $('.form-search').toggleClass('new-class').fadeIn(400);
    });

    /* Collapse Faqs */

    $('.head-faq').click(function() {
        var body = $(this).next('.bdy-faq');
        var icon = $(this).find('i');
        var isOpen = body.hasClass('active');

        $('.bdy-faq').not(body).slideUp().removeClass('active');
        $('.head-faq').not(this).removeClass('active');
        $('.head-faq i').not(icon).removeClass('icon-minus').addClass('icon-plus');

        if (!isOpen) {
            body.slideDown().addClass('active');
            $(this).addClass('active');
            icon.removeClass('icon-plus').addClass('icon-minus');
        }
    });

    /* Owl Carousel */



    $('#slide-home').owlCarousel({
        loop: true,
        rtl: rtl,
        responsiveClass: true,
        items: 1,
        dots: true,
        nav: false,
        autoplay: true,
    });

    $("#categories-slider").owlCarousel({
        loop: false,
        margin: 15,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1199: {
                items: 4,
            }
        },
        dots: true,
        nav: true,
        rtl: rtl,
        autoplay: true,
        navText:['<i class="icon-arrow"></i>','<i class="icon-arrow"></i>'],
    });



    $("#selling-slider").owlCarousel({
        loop: false,
        margin: 15,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                margin: 10,
            },
            992: {
                items: 2,
            },
            1199: {
                items: 4,
            }
        },
        dots: false,
        nav: true,
        rtl: rtl,
        autoplay: true,
        navText:['<i class="icon-arrow"></i>','<i class="icon-arrow"></i>'],
    });

    $("#arrival-slider").owlCarousel({
        loop: false,
        margin: 15,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                margin: 10,
            },
            992: {
                items: 2,
            },
            1199: {
                items: 3,
            }
        },
        dots: false,
        nav: true,
        rtl: rtl,
        autoplay: true,
        navText:['<i class="icon-arrow"></i>','<i class="icon-arrow"></i>'],
    });

    var isDragging = false;

    $('#thumb-slider').owlCarousel({
        loop: true,
        rtl: rtl,
        responsiveClass: true,
        items: 1,
        dots: true,
        nav: false,
        autoplay: true,
    });

});

/* Style Calender */

$(document).ready(function () {
    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();
    let selectedDate = null; // لحفظ اليوم المختار

    // Open calendar on input click
    $("#dateInput").click(function () {
        if ($("#calendar").length === 0) {
            $("body").append('<div class="calendar" id="calendar"></div>');
        }
        generateCalendar(currentYear, currentMonth, selectedDate);
        $("#calendar").css({
            display: "block",
            position: "absolute",
            top: $(this).offset().top + $(this).outerHeight(),
            left: $(this).offset().left
        });
    });

    function generateCalendar(year, month, selectedDay) {
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        let calendarHTML = `
                    <div class="calendar-header">
                        <select id="monthSelect"></select>
                        <select id="yearSelect"></select>
                    </div>
                    <table>
                        <tr>
                            <th>Sun</th> <th>Mon</th> <th>Tue</th> <th>Wed</th>
                            <th>Thu</th> <th>Fri</th> <th>Sat</th>
                        </tr>
                        <tr>`;

        let day = 1;
        for (let i = 0; i < 6; i++) {
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    calendarHTML += "<td></td>";
                } else if (day > lastDate) {
                    break;
                } else {
                    let isSelected = selectedDay === day ? "selected" : "";
                    calendarHTML += `<td class="day ${isSelected}" data-day="${day}" data-month="${month}" data-year="${year}">${day}</td>`;
                    day++;
                }
            }
            calendarHTML += "</tr><tr>";
            if (day > lastDate) break;
        }
        calendarHTML += "</tr></table>";

        $("#calendar").html(calendarHTML);

        // Generate year dropdown (from 1900 to current year)
        let yearDropdown = $("#yearSelect");
        yearDropdown.empty();
        for (let y = 1900; y <= currentYear; y++) {
            yearDropdown.append(`<option value="${y}" ${y === year ? 'selected' : ''}>${y}</option>`);
        }

        // Generate month dropdown
        let monthDropdown = $("#monthSelect");
        monthDropdown.empty();
        monthNames.forEach((m, index) => {
            monthDropdown.append(`<option value="${index}" ${index === month ? 'selected' : ''}>${m}</option>`);
        });

        // Handle year & month change
        $("#yearSelect, #monthSelect").change(function () {
            generateCalendar(parseInt($("#yearSelect").val()), parseInt($("#monthSelect").val()), selectedDate);
        });
    }

    // Select date event
    $(document).on("click", ".day", function () {
        let day = $(this).data("day");
        let month = $(this).data("month") + 1;
        let year = $(this).data("year");

        selectedDate = day; // تحديث اليوم المختار

        $("#dateInput").val(`${year}-${month}-${day}`);
        $("#calendar").remove();
    });

    // Close calendar when clicking outside
    $(document).click(function (e) {
        if (!$(e.target).closest("#dateInput, #calendar").length) {
            $("#calendar").remove();
        }
    });
});

/*Decrease & Increase*/

// var minimum_quanitiy = $(".jsQuantityDecrease").attr("minimum"),
//     productQuantity = minimum_quanitiy;
// $(document).on("click", ".jsQuantityDecrease", function () {
//     var quantity = $(this).parent().find('input[name="count-quat1"]').val();
//     quantity = quantity * 1;
//     var newQuantity = quantity - 1;
//     $(this).parent().find('input[name="count-quat1"]').val(newQuantity);
//     if (newQuantity < 2) {
//         $(this).parent().find(".jsQuantityDecrease").addClass("disabled");
//     } else {
//         $(this).parent().find(".jsQuantityDecrease").removeClass("disabled");
//     }
// }),
//
//     $(document).on("click", ".jsQuantityIncrease", function () {
//         var quantity = $(this).parent().find('input[name="count-quat1"]').val();
//         quantity = quantity * 1;
//         var newQuantity = quantity + 1;
//         $(this).parent().find('input[name="count-quat1"]').val(newQuantity);
//         if (newQuantity >= 2) {
//             $(this).parent().find(".jsQuantityDecrease").removeClass("disabled");
//         } else {
//             $(this).parent().find(".jsQuantityDecrease").addClass("disabled");
//         }
//
//     })

$(document).ready(function () {
    $("body").append(`
        <div class="overlay">
            <img src="" alt="Zoomed Image">
        </div>
    `);

    let isDragging = false;

    $("#thumb-slider img")
        .on("mousedown", function () {
            isDragging = false;
        })
        .on("mousemove", function () {
            isDragging = true;
        })
        .on("mouseup", function () {
            if (!isDragging) {
                let src = $(this).attr("src");
                $(".overlay img").attr("src", src);
                $(".overlay").css("display", "flex").hide().fadeIn();
            }
        });

    $(".overlay").click(function () {
        $(this).fadeOut();
    });
});
