$(document).ready(function () {
    function fetchOrderData(filter = 'day') {
        const requestData = { filter: filter };

        $.ajax({
            url: '/api/orders', // Đảm bảo URL chính xác
            type: 'GET',
            data: requestData,
            success: function (response) {
                console.log('Order API Response:', response);

                let ordersCurrent = 0, percentageChange = 0, changeText = '';

                if (filter === 'day') {
                    ordersCurrent = response.orders_today || 0;
                    percentageChange = response.percentage_change_today || 0;
                } else if (filter === 'month') {
                    ordersCurrent = response.orders_this_month || 0;
                    percentageChange = response.percentage_change_month || 0;
                } else {
                    ordersCurrent = response.orders_this_year || 0;
                    percentageChange = response.percentage_change_last_year || 0;
                }

                changeText = percentageChange >= 0 ? 'tăng' : 'giảm';
                const changeClass = percentageChange >= 0 ? 'text-success' : 'text-danger';

                $('#sales-filter-title').text(`| ${filter === 'day' ? 'Hôm nay' : filter === 'month' ? 'Tháng này' : 'Năm nay'}`);
                $('#sales-order-count').text(ordersCurrent.toLocaleString('vi-VN'));
                $('#sales-order-increase').text(`${Math.abs(percentageChange).toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 1 })}%`).removeClass('text-success text-danger').addClass(changeClass);
                $('#sales-order-increase').next('.text-muted').text(changeText);

                // Loại bỏ xử lý trạng thái đơn hàng
                $('.order-status-info').html('');
            },
            error: function (error) {
                console.log('Order Error:', error);
            }
        });
    }

    // Load initial data with 'day' filter
    fetchOrderData('day');

    // Handle filter selection
    $('.sales-filter .dropdown-menu a[data-filter]').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        console.log('Selected filter:', filter);
        fetchOrderData(filter);
    });
});
