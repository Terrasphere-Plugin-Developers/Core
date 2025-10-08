# Terrasphere Core
Core functionality for the Terrasphere Add-ons. Containing Database structure etc. 

## Dev Environment Setup
### Starting
- Clone from Git repo into `src/addons/Terrasphere/{plugin_names}`
- Install plugins via admin panel (in dependency order)
- Add to config.php: `$config['development']['enabled'] = true;`
- Also this for convenience: `$config['development']['defaultAddOn'] = 'Terrasphere/Core';`

Development output now needs to be imported. This will import everything in the
_output folder. Normally this is done automatically when installing a plugin,
but for development, we import and export manually via commands.

Import command:
- php cmd.php xf-dev:import --addon Terrasphere/Core
- Run after installing or after pulling updates.

Export command:
- php cmd.php xf-dev:export --addon Terrasphere/Core
- Run after making modifications in the development portion of the admin panel.

While making changes in the Admin CP development section, it's also wise to 
update config.php defaultAddOn if necessary, though this is more for convenience.

### Adding an image
For static images we'd like to reference in our addon views:
1. Add the image file to the **_files/styles/default/(addon_id)** directory; relative to the addon's directory.
2. Add the image file to **styles/default/(addon_id)** directory; relative to XF's directory.
3. Create a new entry in the addon's **build.json** file, under **additional_files**.
4. Reference it in the template using: **{{ base_url('styles/default/(addon_id)/(file_name_with_extension)', true) }}**


### Database shenanigans without having to un/install things (Version stuff)
Aside from install and uninstall steps we can also insert upgradeSteps with function names like 'upgrade1000100Step1()'.
Upgrade step can be run with a command like 'php cmd.php xf-addon:upgrade-step Terrasphere/Core 1000100 1'.
Version-Number is found here: https://xenforo.com/docs/dev/add-on-structure/#recommended-version-id-format
Keeping things simple for in-dev simply going to call version from 1.0.0 to 1.0.1 to 1.0.2 to 1.0.3 and so on.
Database has an internal table to cross-check its version-number with the version-number in addon.json
