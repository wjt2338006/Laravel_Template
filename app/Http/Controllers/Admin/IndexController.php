<?php
namespace App\Http\Controllers\Admin;


use App\Libraries\Tools\ModelExtend\ModelExtend;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use League\Flysystem\Exception;


/**
 * User: keith.wang
 * Date: 17-3-11
 */
class IndexController
{
    public function index()
    {
        $staffData = ModelExtend::select([
            ":staff_id" => 3,
            "link" => [
                null,
                "staff_position",
                "position.position_id",
                [
                    "link" =>
                        [
                            "items",
                            "position_id",
                            "item.item_position"
                        ]


                ]
            ],
            "first" => true,
            "resultConvert" => function (&$data) {
                $data["staff_birth"] = ModelExtend::timeToDayStr($data["staff_birth"]);
            }
        ], "staff.staff_id")["data"];
        return view("admin.index");
    }

//获取员工
    public function getStaff()
    {

        $limit = Request::input("params");
        $limit = json_decode($limit, true);
        $limit["custom"] = function ($limit, $query) {

            if (isset($limit["staff_id"])) {
                $query->where("staff_id", $limit["staff_id"]);
            }
            if (isset($limit["staff_name"])) {
                $query->where("staff_name", "like", "%" . $limit["staff_name"] . "%");
            }
            $query->leftJoin("position", "staff_position", "=", "position_id");
        };
        $limit["resultConvert"] = function (&$data) {
            $data["staff_birth"] = ModelExtend::timeToDayStr($data["staff_birth"]);
        };


        $data = ModelExtend::select($limit, "mysql.staff.staff_id");
        return response()->json($data);


    }

//获取员工的详情
    public function getStaffDetail($id)
    {
        $staffData = ModelExtend::select([
            ":staff_id" => $id,
            "link" => [
                null,
                "staff_position",
                "position.position_id",
                [
                    "resultConvert" => function (&$data) {
                        $data["items"] = ModelExtend::select([":item_position" => $data["position_id"]],
                            "mysql.item.item_id")["data"];

                    }


                ]
            ],
            "first" => true,
            "resultConvert" => function (&$data) {
                $data["staff_birth"] = ModelExtend::timeToDayStr($data["staff_birth"]);
            }
        ], "staff.staff_id")["data"];


        $positionData = ModelExtend::select([
            "link" => [
                "items",
                "position_id",
                "mysql.item.item_position"
            ]
        ],
            "position.position_id")["data"];
        try {
            $performanceData = ModelExtend::select([
                ":performance_staff" => $id,
                "desc" => true,
                "resultConvert" => function (&$data) {
                    $data["performance_date"] = ModelExtend::timeToDayStr($data["performance_date"]);
                }
            ], "mysql.performance.performance_id")["data"];
        } catch (\Exception $e) {
            dump($e);
        }

        return response()->json([
            "status" => 200,
            "message" => "get data!",
            "data" => ["staff" => $staffData, "position" => $positionData, "performance" => $performanceData]
        ]);
    }

//添加员工
    public function addStaff()
    {
        $data = Request::input("params");
        ModelExtend::filter($data,
            [
                "staff_name",
                "staff_sex",
                "staff_age",
                "staff_birth",
                "staff_cid",
                "staff_position",
                "staff_basic_price"
            ]);
        dump($data);
        $id = ModelExtend::getBuilder("mysql.staff.staff_id", true)->insertGetId($data);
        return response()->json(["status" => 200, "message" => "ok", "data" => $id]);
    }

    public function delStaff($id)
    {
//        $id = Request::input("params");
        $num = ModelExtend::getBuilder("staff.staff_id", true)->where("staff_id", $id)->delete();
        return response()->json(["status" => 200, "message" => "ok", "data" => $num]);
    }

    public function updateStaff($id)
    {
        try {
            $data = Request::input("params");
//        $id = $data["staff_id"];
            ModelExtend::filter($data,
                [
                    "staff_name",
                    "staff_sex",
                    "staff_age",
                    "staff_birth",
                    "staff_cid",
                    "staff_position",
                    "staff_basic_price"
                ]);
            $num = ModelExtend::getBuilder("staff.staff_id", true)->where("staff_id", "=", $id)->update($data);
            return response()->json(["status" => 200, "message" => "ok", "data" => $num]);
        } catch (\Exception $e) {
            dump($e);
        }


    }


    public function generatePerformance()
    {

        $data = Request::input("params");
        ModelExtend::filter($data,
            [
                "performance_date",
                "performance_staff" => "required",
                "item"
            ]);

        $findItem = function ($itemId) {
            $data = (array)DB::table("item")->where("item_id", $itemId)->first();
            return $data;
        };
        $staff = (array)DB::table("staff")->where("staff_id", $data["performance_staff"])->first();
        $staffP = $staff["staff_basic_price"];

        //[[1,0.8],[5,0.4]]
        $calList = [];
        $price = 0;
        $price += $staffP;
        foreach ($data["item"] as $k => $item) {

            if ($databaseItem = $findItem($k)) {
                $cal["total"] = ((float)$item) * $databaseItem["item_price"];
                $cal["detail"] = $databaseItem;
                $cal["power"] = ((float)$item);
                $price += $cal["total"];
                $calList[] = $cal;
            }
        }

        $insert = [
            "performance_date" => $data["performance_date"],
            "performance_staff" => $data["performance_staff"],
            "performance_detail" => json_encode($calList),
            "performance_price" => $price,

        ];
        ModelExtend::filter($data,
            [
                "performance_date",
                "performance_staff" => "required",
                "item"
            ]);

        $id = ModelExtend::getBuilder("performance.performance_id", true)->insertGetId($insert);
        return response()->json(["status" => true, "message" => "ok", "data" => $id]);


    }


    public function getPosition()
    {
        $limit = Request::input("params");
        $limit = json_decode($limit, true);
        $limit["custom"] = function ($limit, $query) {

            if (isset($limit["position_id"])) {
                $query->where("position_id", $limit["position_id"]);
            }
            if (isset($limit["position_name"])) {
                $query->where("position_name", "like", "%" . $limit["position_name"] . "%");
            }
        };

        $limit["resultConvert"] = function (&$data) {
            $data["items"] = ModelExtend::select([":item_position" => $data["position_id"]],
                "mysql.item.item_id")["data"];
            $data["name"] = $data["position_name"];
        };
        $data = ModelExtend::select($limit, "mysql.position.position_id");
        return response()->json($data);

    }

    public function addPosition()
    {
        $data = Request::input("params");
        ModelExtend::filter($data,
            [
                "position_name" => "required"
            ]);

        $r = ModelExtend::getBuilder("position.position_id")->insertGetId($data);
        return response()->json(["status" => true, "message" => "ok", "data" => $r]);

    }

    public function updatePosition()
    {
        try {
            $data = Request::input("params");
            if (isset($data["position_id"])) {
                $id = $data["position_id"];
                $item = $data["items"];
                ModelExtend::filter($data,
                    [

                        "position_name" => "required",

                    ]);

                ModelExtend::getBuilder("position.position_id", true)
                    ->where("position_id", "=", $id)
                    ->update($data);

                ModelExtend::getBuilder("item.item_id", true)->where("item_position", $id)->delete();
                foreach ($item as $single) {

                    $insert = [
                        "item_name" => $single["item_name"],
                        "item_price" => $single["item_price"],
                        "item_position" => $id
                    ];

                    ModelExtend::getBuilder("item.item_id", true)->insertGetId($insert);
                }
            } else {
                $item = $data["items"];
                ModelExtend::filter($data,
                    [

                        "position_name" => "required",

                    ]);
                $id = ModelExtend::getBuilder("position.position_id", true)
                    ->insertGetId($data);
                ModelExtend::getBuilder("item.item_id", true)->where("item_position", $id)->delete();
                foreach ($item as $single) {
                    $insert = [
                        "item_name" => $single["item_name"],
                        "item_price" => $single["item_price"],
                        "item_position" => $id
                    ];
                    ModelExtend::getBuilder("item.item_id", true)->insertGetId($insert);
                }
            }
            return response()->json(["status" => true, "message" => "ok", "data" => $data]);
        } catch (\Exception $e) {
            dump($e);
        }


    }

    public function delPosition($id)
    {

//        $id = Request::input("params");
        ModelExtend::getBuilder("position.position_id", true)
            ->where("position_id", "=", $id)
            ->delete();
        return response()->json(["status" => true, "message" => "ok"]);
    }


}
