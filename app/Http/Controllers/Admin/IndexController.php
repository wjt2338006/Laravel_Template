<?php
namespace App\Http\Controllers\Admin;



use App\Libraries\Tools\ModelExtend\ModelExtend;
use Illuminate\Support\Facades\Request;


/**
 * User: keith.wang
 * Date: 17-3-11
 */
class IndexController
{
    public function index()
    {
        return view("admin.index");
    }


    public function getStaff()
    {

        $limit = Request::input("params");
        $limit = json_decode($limit, true);
        $data = ModelExtend::select($limit, "mysql.staff.staff_id");
        return response()->json($data);


    }

    public function getStaffDetail($id)
    {
        $staffData = ModelExtend::select([
            ":staff_id" => $id,
            "link" => [
                null,
                "staff_position",
                "position.position_id",
                [
                    "resultConvert"=>function(&$data)
                    {
                        $data["items"]  = ModelExtend::select([":item_position"=>$data["position_id"]],"mysql.item.item_id")["data"];

                    }


                ]
            ],
            "first" => true
        ], "staff.staff_id")["data"];


        $positionData = ModelExtend::select([
            "link" => [
                "items",
                "position_id",
                "mysql.item.item_position"
            ]
        ],
            "position.position_id")["data"];

        return response()->json([
            "status" => 200,
            "message" => "get data!",
            "data" => ["staff" => $staffData, "position" => $positionData]
        ]);
    }


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
        $id = ModelExtend::getBuilder("staff.staff_id", true)->insertGetId($data);
        return response()->json(["status" => 200, "message" => "ok", "data" => $id]);
    }

    public function delStaff()
    {
        $id = Request::input("params");
        $num = ModelExtend::getBuilder("staff.staff_id", true)->where("staff_id", $id)->delete();
        return response()->json(["status" => 200, "message" => "ok", "data" => $num]);
    }

    public function updateStaff($id)
    {
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

        $positionData = ModelExtend::select([
            ":staff_id" => $data["performance_staff"],
            "link" => [
                null,
                "staff_position",
                "position.position_id",
                [
                    "link" =>
                        [
                            "item",
                            "position_id",
                            "item.item_position"
                        ]
                ]
            ]
        ])["data"];
        dump($data);
        $findItem = function ($itemId) use ($positionData) {
            foreach ($positionData as $i) {
                if ($i["item_id"] == $itemId) {
                    return $i;
                }
            }
            return null;
        };
        //[[1,0.8],[5,0.4]]
        $calList = [];
        $price = 0;
        foreach ($data["item"] as $item) {
            if ($databaseItem = $findItem($item[0])) {
                $cal["total"] = $item[1] * $databaseItem["item_price"];
                $cal["detail"] = $databaseItem;
                $cal["power"] = $item[1];
                $price += $cal["total"];
                $calList[] = $cal;
            }
        }

        $insert = [
            "performance_date" => ModelExtend::timeFromSecondStr($data["performance_date"]),
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
        $id = ModelExtend::getBuilder("item.item_id", true)->insertGetId($insert);
        return response()->json(["status" => true, "message" => "ok", "data" => $id]);

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
        $data = Request::input("params");
        $id = $data["position_id"];
        $item = $data["item"];
        ModelExtend::filter($data,
            [

                "position_name" => "required",

            ]);

        ModelExtend::getBuilder("position.position_id")
            ->where("position_id", "=", $id)
            ->update($data);

        ModelExtend::deleteMultiple([":item_position" => $id], "item.item_id");
        foreach ($item as $single) {
            $insert = [
                "item_name" => $single["item_name"],
                "item_price" => $single["item_price"],
                "item_position" => $id
            ];
            $id = ModelExtend::getBuilder("item.item_id")->insertGetId($insert);
        }


        return response()->json(["status" => true, "message" => "ok", "data" => $data]);

    }

    public function delPosition()
    {
        $id = Request::input("params");
        ModelExtend::getBuilder("position.position_id")
            ->where("position_id", "=", $id)
            ->delete();
        return response()->json(["status" => true, "message" => "ok"]);
    }


}