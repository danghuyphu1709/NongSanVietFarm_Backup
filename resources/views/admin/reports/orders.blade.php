@extends('admin.layout.master')
@section('content')
    <style>
        .text-success-bold {
            color: #28a745; /* Màu xanh */
            font-weight: bold; /* In đậm */
        }

        .text-danger-bold {
            color: #dc3545; /* Màu đỏ */
            font-weight: bold; /* In đậm */
        }

        .stat-box {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-box .card-icon {
            font-size: 30px;
            margin-bottom: 15px;
            color: #4154f1;
        }

        .stat-box h6 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .stat-box .percentage-change {
            font-size: 16px;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            font-size: 14px;
        }

        .filter-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            background-color: #ffffff;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .filter-container select {
            width: auto;
            padding: 5px;
            margin-right: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .filter-container button {
            padding: 5px 15px;
            background-color: #4154f1;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-container button:hover {
            background-color: #293b99;
        }

        #orderChartContainer {
            margin-top: 30px;
        }

        #orderChart {
            height: 300px;
        }
    </style>

    <div class="container mt-5">
        <!-- Bộ lọc ngày -->
        <div class="filter-container mb-4">
            <label for="filter-period">Chọn khoảng thời gian:</label>
            <select id="filter-period" class="form-control form-control-sm">
                <option value="today">Hôm nay</option>
                <option value="this_month">Tháng này</option>
                <option value="this_year">Năm nay</option>
            </select>
            <button id="filter-button">Lọc</button>
        </div>

        <div class="row">
            <!-- Đang chờ xử lý -->
            <div class="col-md-3 text-center">
                <div class="stat-box" style="background-color: #fff; min-height: 180px">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h6 id="order-pending">0</h6>
                    <span id="pending-change" class="percentage-change">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Đang chờ xử lý</span>
                </div>
            </div>
            <!-- Đang xử lý -->
            <div class="col-md-3 text-center">
                <div class="stat-box" style="background-color: #fff; min-height: 180px">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <h6 id="order-processing">0</h6>
                    <span id="processing-change" class="percentage-change">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Đang xử lý</span>
                </div>
            </div>
            <!-- Vận chuyển -->
            <div class="col-md-3 text-center">
                <div class="stat-box" style="background-color: #fff; min-height: 180px">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h6 id="order-shipping">0</h6>
                    <span id="shipping-change" class="percentage-change">0% giảm</span>
                    <span class="text-muted small pt-2 ps-1">Vận chuyển</span>
                </div>
            </div>
            <!-- Giao hàng -->
            <div class="col-md-3 text-center">
                <div class="stat-box" style="background-color: #fff; min-height: 180px">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-arrow-down"></i>
                    </div>
                    <h6 id="order-delivered">0</h6>
                    <span id="delivered-change" class="percentage-change">0% giảm</span>
                    <span class="text-muted small pt-2 ps-1">Giao hàng</span>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Đã nhận hàng -->
            <div class="col-md-3 text-center">
                <div class="stat-box" style="background-color: #fff; min-height: 180px">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h6 id="order-received">0</h6>
                    <span id="received-change" class="percentage-change">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Đã nhận hàng</span>
                </div>
            </div>
            <!-- Hoàn thành -->
            <div class="col-md-3 text-center">
                <div class="stat-box" style="background-color: #fff; min-height: 180px">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-award"></i>
                    </div>
                    <h6 id="order-completed">0</h6>
                    <span id="completed-change" class="percentage-change">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Hoàn thành</span>
                </div>
            </div>
            <!-- Đã hủy -->
            <div class="col-md-3 text-center">
                <div class="stat-box" style="background-color: #fff; min-height: 180px">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <h6 id="order-cancelled">0</h6>
                    <span id="cancelled-change" class="percentage-change">0% giảm</span>
                    <span class="text-muted small pt-2 ps-1">Đã hủy</span>
                </div>
            </div>
            <!-- Trả hàng hoàn tiền -->
            <div class="col-md-3 text-center">
                <div class="stat-box" style="background-color: #fff; min-height: 180px">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h6 id="order-return-refund">0</h6>
                    <span id="return-refund-change" class="percentage-change">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Trả hàng</span>
                </div>
            </div>
        </div>

        <!-- Biểu đồ thống kê đơn hàng -->
        <div class="card">
        <div id="orderChartContainer" class="row">
            <div class="col-12">
                <canvas id="orderChart"></canvas>
            </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('orderChart').getContext('2d');
            let orderChart;

            function renderOrderChart(data) {
                if (orderChart) {
                    orderChart.destroy();  // Xóa biểu đồ cũ trước khi vẽ biểu đồ mới
                }

                orderChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Đang chờ xử lý', 'Đang xử lý', 'Vận chuyển', 'Giao hàng', 'Đã nhận hàng', 'Hoàn thành', 'Đã hủy', 'Trả hàng hoàn tiền'],
                        datasets: [{
                            label: 'Số lượng đơn hàng',
                            data: data,
                            backgroundColor: [
                                'rgba(255, 204, 0, 0.7)',
                                'rgba(255, 153, 51, 0.7)',
                                'rgba(51, 204, 255, 0.7)',
                                'rgba(102, 255, 102, 0.7)',
                                'rgba(255, 102, 102, 0.7)',
                                'rgba(51, 153, 102, 0.7)',
                                'rgba(255, 51, 51, 0.7)',
                                'rgba(153, 102, 255, 0.7)'
                            ],
                            borderColor: [
                                '#ffcc00', '#ff9933', '#33ccff', '#66ff66', '#ff6666', '#339966', '#ff3333', '#9966ff'
                            ],
                            borderWidth: 2,
                            hoverBackgroundColor: [
                                'rgba(255, 204, 0, 1)',
                                'rgba(255, 153, 51, 1)',
                                'rgba(51, 204, 255, 1)',
                                'rgba(102, 255, 102, 1)',
                                'rgba(255, 102, 102, 1)',
                                'rgba(51, 153, 102, 1)',
                                'rgba(255, 51, 51, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            hoverBorderColor: [
                                '#e6b800', '#e68a00', '#29a3a3', '#29a329', '#cc0000', '#26734d', '#cc0000', '#7f00ff'
                            ]
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.2)'
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    },
                                    color: '#333'
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.2)'
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    },
                                    color: '#333'
                                }
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 14
                                },
                                cornerRadius: 4,
                                padding: 10,
                                displayColors: false
                            }
                        }
                    }
                });
            }

            function applyChangeClass(element, changeType) {
                if (changeType === 'tăng') {
                    element.className = 'percentage-change text-success-bold';
                } else if (changeType === 'giảm') {
                    element.className = 'percentage-change text-danger-bold';
                } else {
                    element.className = 'percentage-change';
                }
            }

            function updateDataBasedOnFilter(period) {
                fetch(`http://127.0.0.1:8000/api/report/orders?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        const orderData = data[period];

                        $('#order-pending').text(orderData['Đang chờ xử lý'].count);
                        applyChangeClass(document.getElementById('pending-change'), orderData['Đang chờ xử lý'].change);
                        $('#pending-change').text(``);

                        $('#order-processing').text(orderData['Đang xử lý'].count);
                        applyChangeClass(document.getElementById('processing-change'), orderData['Đang xử lý'].change);
                        $('#processing-change').text(``);

                        $('#order-shipping').text(orderData['Vận chuyển'].count);
                        applyChangeClass(document.getElementById('shipping-change'), orderData['Vận chuyển'].change);
                        $('#shipping-change').text(``);

                        $('#order-delivered').text(orderData['Giao hàng'].count);
                        applyChangeClass(document.getElementById('delivered-change'), orderData['Giao hàng'].change);
                        $('#delivered-change').text(``);

                        $('#order-received').text(orderData['Đã nhận hàng'].count);
                        applyChangeClass(document.getElementById('received-change'), orderData['Đã nhận hàng'].change);
                        $('#received-change').text(``);

                        $('#order-completed').text(orderData['Hoàn thành'].count);
                        applyChangeClass(document.getElementById('completed-change'), orderData['Hoàn thành'].change);
                        $('#completed-change').text(``);

                        $('#order-cancelled').text(orderData['Đã hủy'].count);
                        applyChangeClass(document.getElementById('cancelled-change'), orderData['Đã hủy'].change);
                        $('#cancelled-change').text(``);

                        $('#order-return-refund').text(orderData['Trả hàng hoàn tiền'].count);
                        applyChangeClass(document.getElementById('return-refund-change'), orderData['Trả hàng hoàn tiền'].change);
                        $('#return-refund-change').text(``);

                        renderOrderChart([
                            orderData['Đang chờ xử lý'].count,
                            orderData['Đang xử lý'].count,
                            orderData['Vận chuyển'].count,
                            orderData['Giao hàng'].count,
                            orderData['Đã nhận hàng'].count,
                            orderData['Hoàn thành'].count,
                            orderData['Đã hủy'].count,
                            orderData['Trả hàng hoàn tiền'].count
                        ]);
                    })
                    .catch(error => console.error('Error:', error));
            }

            $('#filter-button').on('click', function () {
                const period = $('#filter-period').val();
                updateDataBasedOnFilter(period);
            });

            updateDataBasedOnFilter('today');
        });
    </script>
@endsection
