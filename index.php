<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>e-rapat - Calendar</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet'>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style type="text/css" media="screen">
        /* Scroll to TOP */
        .text {
            padding: 1em;
            margin: 3em auto;
            max-width: 437px;
            font-size: 2em;
            line-height: 1.2;
            font-weight: lighter;
        }

        .backTop {
            position: fixed;
            bottom: 0;
            right: 0;
            display: inline-block;
            padding: 1em;
            margin: 1em;
            background: #ffffff;
            border: 2px solid #0078d4;
            z-index: 999;
        }

        .backTop:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="row">
        <div id="contextMenu" class="dropdown clearfix"></div>
        <div class="panel panel-default hidden-print" style="width: 93%;margin: 0 auto;border-radius: 0;">
            <div class="panel-heading">
                <h3 class="panel-title">Pengaturan Tampilan kalender</h3>
            </div>
            <div class="panel-body vertical-align">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="calendar_view">Pilih Mode Tampilan</label>
                        <select class="form-control" id="calendar_view">
                            <option value="month">Tampilkan Kalendar Berdasarkan Bulan</option>
                            <option value="agendaWeek">Tampilkan Kalendar Berdasarkan Minggu</option>
                            <option value="agendaDay">Tampilkan Kalendar Berdasarkan Hari</option>
                            <option value="listWeek">Tampilkan Kalendar Berdasarkan List Agenda Rapat</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="calendar_start_time">Jam Awal Rapat :</label>
                        <select class="form-control" id="calendar_start_time">
                            <?php
                            for ($x = 1; $x <= 23; $x++) {
                                if ($x < 10) {
                                    echo "<option value=0" . $x . ":00:00>0" . $x . ":00 AM</option>";
                                } else {
                                    if ($x >= 12) {
                                        echo "<option value=" . $x . ":00:00>" . $x . ":00 PM</option>";
                                    } else {
                                        echo "<option value=" . $x . ":00:00>" . $x . ":00 AM</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="calendar_end_time">Jam Akhir Rapat :</label>
                        <select class="form-control" id="calendar_end_time">
                            <?php
                            for ($x = 1; $x <= 23; $x++) {
                                if ($x < 10) {
                                    echo "<option value=0" . $x . ":00:00>0" . $x . ":00 AM</option>";
                                } else {
                                    if ($x >= 12) {
                                        echo "<option value=" . $x . ":00:00>" . $x . ":00 PM</option>";
                                    } else {
                                        echo "<option value=" . $x . ":00:00>" . $x . ":00 AM</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label style="cursor:pointer" for="clickme"><input class='showHideWeekend filter' id="clickme" type="checkbox" checked="checked" /> <span class="chkprimary faCheckIcon">Klik disini untuk Menampilkan atau Menyembunyikan Akhir Pekan ( Sabtu - Minggu )</span></label>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default hidden-print" style="width: 95%;margin: 15px auto;border-radius: 0;">
        <div class="panel-heading">
            <h3 class="panel-title">Filter Kalender</h3>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <label for="calendar_view">Berdasarkan Media Meeting</label>
                <div class="input-group">
                    <select class="filter" id="type_filter" multiple="multiple">
                        <option value='all'>Semua Media Meeting</option>
                        <?php
                        include "db.php";
                        $sql = "SELECT * FROM meeting_sub_type";
                        try {
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetchAll();
                        } catch (Exception $ex) {
                            echo ($ex->getMessage());
                        }
                        echo "<option disabled>-- Media Online --</option>";
                        foreach ($result as $key => $st) {
                            if ($st['type_id'] == 1) {

                                echo "<option value=" . $st['id'] . ">" . $st['meeting_subtype'] . "</option>";
                            }
                        }
                        echo "<option disabled>-- Media Offline --</option>";
                        foreach ($result as $key => $st) {
                            if ($st['type_id'] == 2) {
                                echo "<option value=" . $st['id'] . ">" . $st['meeting_subtype'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label for="calendar_view">Berdasarkan Esalon 2</label>
                <div class="input-group">
                    <select class="filter" id="bagian_filter" multiple="multiple">
                        <option value='all'>Semua Esalon 2</option>
                        <?php
                        include "db.php";
                        $sql = "SELECT * FROM meeting_department";
                        try {
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetchAll();
                        } catch (Exception $ex) {
                            echo ($ex->getMessage());
                        }
                        foreach ($result as $key => $d) {
                            echo "<option value=" . $d['id'] . ">" . $d['department_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12 display-flex-div">
                <form id="radioForm" style="margin-left: -20px;">
                    <div class="input-group">
                        <label class="checkbox-inline"><input class='filter' type="checkbox" value="Online" checked><span class="chksuccess faCheckIcon">Tampilkan Hanya Rapat Online</span></label>
                        <label class="checkbox-inline"><input class='filter' type="checkbox" value="Offline" checked><span class="chkdanger faCheckIcon">Tampilkan Hanya Rapat Offline</span></label>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="wrapper">
        <div id="loading"></div>
        <div class="print-visible" style="width: 95%;margin: 0 auto; padding: 25px 25px 25px 25px;box-shadow: 0px 2px 7px rgba(0,0,0,0.2);" id="calendar"></div>

        <!-- Start of Scroll to TOP -->
        <div class="backTop">KEMBALI KE ATAS</div>
        <!-- End of Scroll to TOP -->
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale-all.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/id.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js'></script>
    <script type="text/javascript" src="script.js"></script>
    <script>
        $('.chksuccess').click(function() {
            $(this).toggleClass('chkdisables faTimesIcon');
        });
        $('.chkdanger').click(function() {
            $(this).toggleClass('chkdisables faTimesIcon');
        });
        $('.chkprimary').click(function() {
            $(this).toggleClass('chkdisables faTimesIcon');
        });

        // Start of Scroll to TOP //
        var $backToTop = $(".backTop");
        $backToTop.hide();
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 100) {
                $backToTop.fadeIn();
            } else {
                $backToTop.fadeOut();
            }
        });

        $backToTop.on('click', function(e) {
            $("html, body").animate({
                scrollTop: 0
            }, 500);
        });
        // End of Scroll to TOP //
    </script>
</body>

</html>