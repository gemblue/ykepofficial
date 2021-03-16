<h1 class="mb-5"><?= $title; ?></h1>

<div class="mb-5">
    <h4>Selling Charts</h4>   
    
    <form class="form-inline mt-3" action="" method="get">
        <div class="form-group mb-2">
            <input type="text" name="start" class="form-control" data-toggle="datepicker" placeholder="Start Date .." value="<?php echo $this->input->get('start')?>">&nbsp;
        </div>
        <div class="form-group mb-2">
            <input type="text" name="end" class="form-control datepicker" data-toggle="datepicker" placeholder="End Date .." value="<?php echo $this->input->get('end')?>">&nbsp;
        </div>
        <div class="form-group mb-2">
            <select name="product_id" class="form-control">
                <option value="">Semua ..</option>
                <?php foreach($products as $product) :?>
                    <option value="<?php echo $product['id']?>" <?php echo ($product['id'] == $this->input->get('product_id')) ? 'selected' : ''?>><?php echo $product['product_name']?></option>
                <?php endforeach;?>
            </select>&nbsp;
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-success mb-2">Filter</button>
            <a href="<?php echo site_url('admin/dashboard/dashboard/selling')?>" class="btn btn-danger mb-2">Reset</a>
        </div>
    </form>

    <hr/>

    <div class="mt-3">Periode tanggal <b><?php echo date('d M Y', strtotime($start))?></b> s/d <b><?php echo date('d M Y', strtotime($end));?></b></div>
    
    <table class="mt-3 table table-bordered">
        <tr><th>Jumlah Terjual</th><td><?php echo $total_selling;?></td></tr>
        <tr><th>Nilai Transaksi</th><td>Rp. <?php echo number_format($total_transaction);?></td></tr>
    </table>

    <canvas id="sellingChart" width="400" height="150"></canvas>
</div>

<hr/>

<div class="mt-5" id="totalSelling">
    <h4>Total Selling per Products</h4>    
    
    <form class="form-inline mt-3" action="#totalSelling" method="get">
        <div class="form-group mb-2">
            <input type="text" name="start" class="form-control" data-toggle="datepicker" placeholder="Start Date .." value="<?php echo $this->input->get('start')?>">&nbsp;
        </div>
        <div class="form-group mb-2">
            <input type="text" name="end" class="form-control datepicker" data-toggle="datepicker" placeholder="End Date .." value="<?php echo $this->input->get('end')?>">&nbsp;
        </div>
        <button type="submit" class="btn btn-success mb-2">Filter</button>&nbsp;
        <a href="<?php echo site_url('admin/dashboard/dashboard/selling#totalSelling')?>" class="btn btn-danger mb-2">Reset</a>
    </form>

    <div class="mt-5">
        <div class="row">
            <div class="col">
                <h4>Premium</h4> 

                <table class="table table-bordered">
                    <tr>
                        <th>Product</th><th>Total Sell</th>
                    </tr>

                    <?php 
                    $total = 0; 
                    
                    foreach($products as $product)
                    {
                        $selling = $this->Order_model->getClosingOrderByProduct($product['id'], $this->input->get('start'), $this->input->get('end'));
                        ?>
                        <tr>
                            <td><?php echo $product['product_name']?></td>
                            <td><?php echo $selling?></td>
                        </tr>
                        <?php

                        $total = $total + $selling;
                    }
                    ?>
                    <tr>
                        <td><b>Total Selling</b></td>
                        <td><?php echo $total;?></td>
                    </tr>
                </table>
                
            </div>
            <div class="col">
                <h4>Free</h4> 
                <table class="table table-bordered">
                    <tr>
                        <th>Product</th><th>Total Sell</th>
                    </tr>

                    <?php 
                    $total = 0; 
                    
                    foreach($free_products as $product)
                    {
                        $selling = $this->Order_model->getClosingOrderByProduct($product['id'], $this->input->get('start'), $this->input->get('end'));
                        ?>
                        <tr>
                            <td><?php echo $product['product_name']?></td>
                            <td><?php echo $selling?></td>
                        </tr>
                        <?php

                        $total = $total + $selling;
                    }
                    ?>
                    <tr>
                        <td><b>Total Selling</b></td>
                        <td><?php echo $total;?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<input type="hidden" class="site_url" value="<?php echo site_url()?>"/>
<input type="hidden" class="product_id" value="<?php echo $this->input->get('product_id')?>"/>
<input type="hidden" class="start" value="<?php echo $this->input->get('start')?>"/>
<input type="hidden" class="end" value="<?php echo $this->input->get('end')?>"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js"></script>

<script>
var site_url = $('.site_url').val();
var start = $('.start').val();
var end = $('.end').val();
var product_id = $('.product_id').val();

/**
 * Subscribe Chart
 */
var sellingChart = new Chart(document.getElementById('sellingChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: [],
            data: [],
            borderWidth: 1,
			borderColor: '#2ecc71'
        }]
    }
});

$.getJSON( site_url + "payment/services/sellingPerformance?start=" + start + '&end=' + end + '&product_id=' + product_id, function( response ) {
    var i = 0;
    
    for (var key in response) {
		var date = response[i]['date'];
		
        sellingChart.data.datasets[0].data[i] = response[i]['total'];
        sellingChart.data.labels[i] = date.toString('MMMM dS, yyyy');
        i++;
    }
    
    sellingChart.update();
});
</script>