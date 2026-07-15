<?php

class GetInfoLibsApiController
{
    public static function getInfoLibs($req, $res)
    {
        $res->set("Access-Control-Allow-Origin", "*");
        $res->json([
            "status" => 200,
            "message" => "ok",
            "data" => $req->body,
        ]);
    }

    public static function contact($req, $res)
    {
        $name = $req->query["name"] ?? "guest";

        $res->render("contact", [
            "name" => $name,
            "say" => "Thanks for reaching out!",
        ], [
            "title" => $name,
            "navbar" => "Contact",
        ]);
    }
}
