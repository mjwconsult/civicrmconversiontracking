# vitiligodonatetracking

- Submit google and facebook tracking events from the Thank You page of donations
and memberships.

- The extension assumes you already have Google Analytics and/or the Facebook Pixel already configured on your website with tracking IDs/code. The extension submits donation/membership completion events by calling those platforms' APIs.

- If browser's Do Not Track option is set, respect this.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.0+
* CiviCRM 5.0+

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl vitiligodonatetracking@https://github.com/vitiligosociety/vitiligodonatetracking/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/vitiligosociety/vitiligodonatetracking.git
cv en vitiligodonatetracking
```

