<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/health-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.healthCheck',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/execute-solution' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.executeSolution',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/update-config' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.updateConfig',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UFQSQwpd7XaUguID',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3pER9XkbbMjtS9p8',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ahA8NSHpDfrJBuD7',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logoutButton',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/SuperAdmin/Dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::iA8I323Vbs016dIA',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/SuperAdmin/Employee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vzlCzZzxC5DhhNCf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/SuperAdmin/Employee/ArchiveEmployee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MO6TT0cLr7mVPYD9',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/SuperAdmin/Employee/AddEmployee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9gYlFzfxO8Le73Pk',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::D3LrVNL7eN7FcrMt',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/SuperAdmin/Leave' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3F8njUiFqVcoU5cq',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/SuperAdmin/Announcement' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7xtQkuIluud82EMS',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tQ1SwRZdoXhNIgBU',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/SuperAdmin/Department' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZcFHDNxUzaDQB1bX',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/SuperAdmin/Attendance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1hFUFVkQL1FPZCNW',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5KNldM7NDFAWBMoV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Employee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5n7t7p4bXu4aSaH8',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Employee/ArchiveEmployee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vTSeqtyitC3gKjgk',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Employee/AddEmployee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::x1NoJdPpLblykhqc',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cIgI2RRH3R84jfMo',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Leave' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7dbWw3PUUyII010d',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Announcement' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6IVufEpyRY3MpCEL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Ng410jFvd4l3W3cI',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Attendance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZnCLEliAXotQCuH4',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Department' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::G2pSbiAyK4kidfjF',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Department/DepartmentArchived' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7x616ZiKLxFHvCYv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Department/AddDepartment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::z6QLSk6g7TCzJMuT',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Admin/Department/AddPosition' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::iREt2Z2QUhQaOOrR',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Employee/Dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mLQXuQ2IYTQji3db',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Employee/Leave' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VY6BLMrUrEkW09O6',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Employee/MyAccount' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lXv1Sy402AGPvImj',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GNh4mWnzl4uZ3SnD',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Employee/Attendance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GsCw81A42a3LOspM',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Employee/ClockIn' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::s5ZxOD7cTtPf3sz0',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Employee/ClockOut' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OWtxTgpTCDnYCgA1',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/current-time' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'current-time',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/SuperAdmin/(?|Employee/(?|EditEmployee/([^/]++)(?|(*:58))|PreviewEmployee/([^/]++)(*:90)|Archive/([^/]++)(*:113)|Restore/([^/]++)(*:137))|Read/([^/]++)(*:159)|positions/([^/]++)(*:185))|/Admin/(?|Employee/(?|EditEmployee/([^/]++)(?|(*:240))|PreviewEmployee/([^/]++)(*:273)|Archive/([^/]++)(*:297)|Restore/([^/]++)(*:321))|Read/([^/]++)(*:343)|Department/(?|Update(?|Department/([^/]++)(*:393)|Position/([^/]++)(*:418))|Deleted(?|/([^/]++)(*:446)|Restored/([^/]++)(*:471)|Position(?|/([^/]++)(*:499)|Restored/([^/]++)(*:524))))|positions/([^/]++)(*:553))|/Employee/Read/([^/]++)(*:585))/?$}sDu',
    ),
    3 => 
    array (
      58 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::u1PZCSLjazRbAtpW',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Au1jR42pFIN1vlla',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      90 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::D3V8sc1BOo8LsnzK',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      113 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tuux3HwOmbjBbkWK',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      137 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZGRx82TNQ0YYHhgc',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      159 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rBaxbxxZzV4eiQN4',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      185 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rbBSZAV4uAzvXS4G',
          ),
          1 => 
          array (
            0 => 'department_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      240 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::awueFEB8VqQitSJx',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pEb9fLtuZJJYLiPL',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      273 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Z9XZLsydjLug0kNG',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      297 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::megy7HJPO6lBbAc8',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      321 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::D7xm45d0xaqyZK9N',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      343 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uBmD7GPQsL7tnJq1',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      393 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8W1UqFF6e0urWGWq',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      418 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lJO6hNZGSNx5l1aX',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      446 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3nJabdMlYMhOglXM',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      471 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bPfqH3aOCQlcTHHl',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      499 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ezVqVtYWlkv1YhYW',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      524 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5yLfyqpCYlNsPzZY',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      553 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kCLIQJGHwn88UjYx',
          ),
          1 => 
          array (
            0 => 'department_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      585 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pgYrfioC2m1BbHVn',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.healthCheck' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/health-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController',
        'as' => 'ignition.healthCheck',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.executeSolution' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/execute-solution',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController',
        'as' => 'ignition.executeSolution',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.updateConfig' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/update-config',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController',
        'as' => 'ignition.updateConfig',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UFQSQwpd7XaUguID' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:77:"function (\\Illuminate\\Http\\Request $request) {
    return $request->user();
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000005280000000000000000";}}',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::UFQSQwpd7XaUguID',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3pER9XkbbMjtS9p8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LoginDashboardController@login',
        'controller' => 'App\\Http\\Controllers\\LoginDashboardController@login',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::3pER9XkbbMjtS9p8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ahA8NSHpDfrJBuD7' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LoginDashboardController@AuthLogin',
        'controller' => 'App\\Http\\Controllers\\LoginDashboardController@AuthLogin',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ahA8NSHpDfrJBuD7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logoutButton' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LoginDashboardController@logoutButton',
        'controller' => 'App\\Http\\Controllers\\LoginDashboardController@logoutButton',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logoutButton',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::iA8I323Vbs016dIA' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@dashboard',
        'controller' => 'App\\Http\\Controllers\\DashboardController@dashboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::iA8I323Vbs016dIA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vzlCzZzxC5DhhNCf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Employee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@employee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@employee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::vzlCzZzxC5DhhNCf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MO6TT0cLr7mVPYD9' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Employee/ArchiveEmployee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@archiveemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@archiveemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::MO6TT0cLr7mVPYD9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9gYlFzfxO8Le73Pk' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Employee/AddEmployee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@addemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@addemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::9gYlFzfxO8Le73Pk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::D3LrVNL7eN7FcrMt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'SuperAdmin/Employee/AddEmployee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@insertemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@insertemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::D3LrVNL7eN7FcrMt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::u1PZCSLjazRbAtpW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Employee/EditEmployee/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@editemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@editemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::u1PZCSLjazRbAtpW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Au1jR42pFIN1vlla' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'SuperAdmin/Employee/EditEmployee/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@updateemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@updateemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Au1jR42pFIN1vlla',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::D3V8sc1BOo8LsnzK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Employee/PreviewEmployee/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@previewemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@previewemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::D3V8sc1BOo8LsnzK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tuux3HwOmbjBbkWK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Employee/Archive/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@archive',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@archive',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::tuux3HwOmbjBbkWK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZGRx82TNQ0YYHhgc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Employee/Restore/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@restore',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@restore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ZGRx82TNQ0YYHhgc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3F8njUiFqVcoU5cq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Leave',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@leave',
        'controller' => 'App\\Http\\Controllers\\LeaveController@leave',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::3F8njUiFqVcoU5cq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7xtQkuIluud82EMS' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Announcement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@announcement',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@announcement',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::7xtQkuIluud82EMS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tQ1SwRZdoXhNIgBU' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'SuperAdmin/Announcement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@save_task',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@save_task',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::tQ1SwRZdoXhNIgBU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rBaxbxxZzV4eiQN4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Read/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@read',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@read',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::rBaxbxxZzV4eiQN4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZcFHDNxUzaDQB1bX' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Department',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@department',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@department',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ZcFHDNxUzaDQB1bX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rbBSZAV4uAzvXS4G' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/positions/{department_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@getPositions',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@getPositions',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::rbBSZAV4uAzvXS4G',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1hFUFVkQL1FPZCNW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'SuperAdmin/Attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@attendance',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@attendance',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::1hFUFVkQL1FPZCNW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5KNldM7NDFAWBMoV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@dashboard',
        'controller' => 'App\\Http\\Controllers\\DashboardController@dashboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5KNldM7NDFAWBMoV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5n7t7p4bXu4aSaH8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Employee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@employee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@employee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5n7t7p4bXu4aSaH8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vTSeqtyitC3gKjgk' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Employee/ArchiveEmployee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@archiveemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@archiveemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::vTSeqtyitC3gKjgk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::x1NoJdPpLblykhqc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Employee/AddEmployee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@addemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@addemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::x1NoJdPpLblykhqc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cIgI2RRH3R84jfMo' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Admin/Employee/AddEmployee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@insertemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@insertemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::cIgI2RRH3R84jfMo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::awueFEB8VqQitSJx' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Employee/EditEmployee/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@editemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@editemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::awueFEB8VqQitSJx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pEb9fLtuZJJYLiPL' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Admin/Employee/EditEmployee/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@updateemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@updateemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::pEb9fLtuZJJYLiPL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Z9XZLsydjLug0kNG' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Employee/PreviewEmployee/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@previewemployee',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@previewemployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Z9XZLsydjLug0kNG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::megy7HJPO6lBbAc8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Employee/Archive/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@archive',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@archive',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::megy7HJPO6lBbAc8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::D7xm45d0xaqyZK9N' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Employee/Restore/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeController@restore',
        'controller' => 'App\\Http\\Controllers\\EmployeeController@restore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::D7xm45d0xaqyZK9N',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7dbWw3PUUyII010d' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Leave',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@leave',
        'controller' => 'App\\Http\\Controllers\\LeaveController@leave',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::7dbWw3PUUyII010d',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6IVufEpyRY3MpCEL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Announcement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@announcement',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@announcement',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::6IVufEpyRY3MpCEL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Ng410jFvd4l3W3cI' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Admin/Announcement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@save_task',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@save_task',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Ng410jFvd4l3W3cI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uBmD7GPQsL7tnJq1' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Read/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@read',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@read',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::uBmD7GPQsL7tnJq1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZnCLEliAXotQCuH4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@attendance',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@attendance',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ZnCLEliAXotQCuH4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::G2pSbiAyK4kidfjF' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Department',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@department',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@department',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::G2pSbiAyK4kidfjF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8W1UqFF6e0urWGWq' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Admin/Department/UpdateDepartment/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@updatedepartment',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@updatedepartment',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::8W1UqFF6e0urWGWq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7x616ZiKLxFHvCYv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Department/DepartmentArchived',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@departmentarchived',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@departmentarchived',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::7x616ZiKLxFHvCYv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3nJabdMlYMhOglXM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Department/Deleted/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@deleted',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@deleted',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::3nJabdMlYMhOglXM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bPfqH3aOCQlcTHHl' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Department/DeletedRestored/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@deletedrestored',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@deletedrestored',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::bPfqH3aOCQlcTHHl',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ezVqVtYWlkv1YhYW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Department/DeletedPosition/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@deletedposition',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@deletedposition',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ezVqVtYWlkv1YhYW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5yLfyqpCYlNsPzZY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/Department/DeletedPositionRestored/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@deletedpositionrestored',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@deletedpositionrestored',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5yLfyqpCYlNsPzZY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::z6QLSk6g7TCzJMuT' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Admin/Department/AddDepartment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@adddepartment',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@adddepartment',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::z6QLSk6g7TCzJMuT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lJO6hNZGSNx5l1aX' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Admin/Department/UpdatePosition/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@updateposition',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@updateposition',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::lJO6hNZGSNx5l1aX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::iREt2Z2QUhQaOOrR' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Admin/Department/AddPosition',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@addposition',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@addposition',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::iREt2Z2QUhQaOOrR',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kCLIQJGHwn88UjYx' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Admin/positions/{department_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\DepartmentController@getPositions',
        'controller' => 'App\\Http\\Controllers\\DepartmentController@getPositions',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::kCLIQJGHwn88UjYx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mLQXuQ2IYTQji3db' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Employee/Dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'employee',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@dashboard',
        'controller' => 'App\\Http\\Controllers\\DashboardController@dashboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::mLQXuQ2IYTQji3db',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VY6BLMrUrEkW09O6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Employee/Leave',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'employee',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@leave',
        'controller' => 'App\\Http\\Controllers\\LeaveController@leave',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::VY6BLMrUrEkW09O6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lXv1Sy402AGPvImj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Employee/MyAccount',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'employee',
        ),
        'uses' => 'App\\Http\\Controllers\\MyAccountController@myaccount',
        'controller' => 'App\\Http\\Controllers\\MyAccountController@myaccount',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::lXv1Sy402AGPvImj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GNh4mWnzl4uZ3SnD' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Employee/MyAccount',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'employee',
        ),
        'uses' => 'App\\Http\\Controllers\\MyAccountController@updatemyaccount',
        'controller' => 'App\\Http\\Controllers\\MyAccountController@updatemyaccount',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::GNh4mWnzl4uZ3SnD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pgYrfioC2m1BbHVn' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Employee/Read/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'employee',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@read',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@read',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::pgYrfioC2m1BbHVn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GsCw81A42a3LOspM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Employee/Attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'employee',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@attendance',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@attendance',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::GsCw81A42a3LOspM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::s5ZxOD7cTtPf3sz0' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Employee/ClockIn',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'employee',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@clockIn',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@clockIn',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::s5ZxOD7cTtPf3sz0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OWtxTgpTCDnYCgA1' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Employee/ClockOut',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'employee',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@clockOut',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@clockOut',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::OWtxTgpTCDnYCgA1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'current-time' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'current-time',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'employee',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@currentTime',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@currentTime',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'current-time',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
