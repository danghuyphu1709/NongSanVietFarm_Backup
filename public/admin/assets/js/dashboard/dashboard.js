$(document).ready(function () {
    function fetchData() {
        $.when(
            $.ajax({
                url: "/api/orders/total",
                type: "GET",
                data: { filter: "day" },
            }),
            $.ajax({
                url: "/api/users",
                type: "GET",
                data: { filter: "day" },
            }),
            $.ajax({
                url: "/api/orders",
                type: "GET",
                data: { filter: "day" },
            })
        ).done(function (revenueResponse, usersResponse, ordersResponse) {
            const revenueData = revenueResponse[0];
            const usersData = usersResponse[0];
            const ordersData = ordersResponse[0];

            updateRevenueChart(revenueData);
            updateCombinedChart(usersData, ordersData);
        });
    }

    function updateRevenueChart(revenueData) {
        const revenueDataPoints = [
            parseFloat(revenueData.total_today) * 0.9 || 0,
            parseFloat(revenueData.total_today) || 0,
            parseFloat(revenueData.total_today) * 1.1 || 0,
        ];

        new ApexCharts(document.querySelector("#revenueChart"), {
            series: [
                {
                    name: "Doanh thu",
                    data: revenueDataPoints,
                },
            ],
            chart: {
                type: "line",
                height: 350,
                toolbar: {
                    show: false,
                },
            },
            stroke: {
                curve: "smooth",
                width: 2,
            },
            xaxis: {
                categories: ["Sáng", "Trưa", "Chiều"],
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return val.toLocaleString("vi-VN");
                    },
                },
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toLocaleString("vi-VN", {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0,
                        });
                    },
                },
            },
            markers: {
                size: 4,
                hover: {
                    size: 6,
                },
            },
            colors: ["#4154f1"],
            legend: {
                position: "top",
                horizontalAlign: "left",
                offsetX: 40,
            },
        }).render();
    }

    function updateCombinedChart(usersData, ordersData) {
        const customersData = [
            parseInt(usersData.users_today) * 0.7 || 0,
            parseInt(usersData.users_today) || 0,
            parseInt(usersData.users_today) * 1.3 || 0,
        ];

        const ordersDataPoints = [
            parseInt(ordersData.orders_today) * 0.9 || 0,
            parseInt(ordersData.orders_today) || 0,
            parseInt(ordersData.orders_today) * 1.1 || 0,
        ];

        new ApexCharts(document.querySelector("#combinedChart"), {
            series: [
                {
                    name: "Khách hàng",
                    data: customersData,
                },
                {
                    name: "Đơn hàng",
                    data: ordersDataPoints,
                },
            ],
            chart: {
                type: "line",
                height: 350,
                toolbar: {
                    show: false,
                },
            },
            stroke: {
                curve: "smooth",
                width: 2,
            },
            xaxis: {
                categories: ["Sáng", "Trưa", "Chiều"],
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return val.toLocaleString("vi-VN");
                    },
                },
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toLocaleString("vi-VN", {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0,
                        });
                    },
                },
            },
            markers: {
                size: 4,
                hover: {
                    size: 6,
                },
            },
            colors: ["#2eca6a", "#ff771d"], // Màu sắc cho Khách hàng và Đơn hàng
            legend: {
                position: "top",
                horizontalAlign: "left",
                offsetX: 40,
            },
        }).render();
    }

    fetchData();
});
