<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
        <meta charset="utf-8" />
        <title> Google Finance Market data</title>
         <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
            body{
                font-size: 13px;
            }
            .table td, .table th {
                padding: .25rem;
            }
        </style>
    </head>

    <body>
        <?php include_once('marketdata-lib.php'); ?>
        <section id="about">
            <div class="container">
                <div class="row">
                    <?php 
                        $data = get_financial_entity();
                        //print_r($data);
                    ?>
                    <div class="col-lg-12 mx-auto">
                        <h2>Google Finance Market Data</h2>
                        <p class="lead">
                            This is Google Finance Market Data API in a Tabular Format
                        </p>
                        <?php if(count($data) > 0){ ?>
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">Symbol</th>
                                        <th scope="col">Name </th>
                                        <th scope="col">Last Value</th>
                                        <th scope="col">Percent Change</th>
                                        <th scope="col">Value Change</th>
                                        <th scope="col">Change</th>
                                        <th scope="col">Exchange</th>
                                        <th scope="col">Currency Code</th>
                                        <th scope="col">Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data as $key => $stock ): ?>
                                        <tr>
                                            <?php $color = ($stock->change == 'NEGATIVE') ? 'style="color: red;"' : 'style="color: #44c644;"'; ?>
                                            <td><?php echo $stock->symbol; ?></td>
                                            <td><?php echo $stock->name; ?></td>
                                            <td><?php echo $stock->last_value; ?></td>
                                            <td <?php echo $color; ?>><?php echo $stock->percent_change; ?></td>
                                            <td <?php echo $color; ?>><?php echo $stock->value_change; ?></td>
                                            <td><?php echo $stock->change; ?></td>
                                            <td><?php echo $stock->exchange; ?></td>
                                            <td><?php echo $stock->currency_code; ?></td>
                                            <td><?php echo $stock->last_updated_time; ?></td>
                                        </tr>  
                                    <?php endforeach; ?>                              
                                </tbody>
                            </table>
                        <?php } ?>
                            
                        </div>
                
                    </div>
                </div> 
                <!-- End of row -->
            </div> 
            <!-- End of container -->
        </section>
        <!-- End of section -->
        
    </body>
</html>