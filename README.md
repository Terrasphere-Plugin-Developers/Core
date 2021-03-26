# Terrasphere Core
Core functionality for the Terrasphere Add-ons. Containing Database structure etc. 

## Luma's notes on how to do XF stuff...
### Adding an image
For static images we'd like to reference in our addon views:
1. Add the image file to the **_files/styles/default/(addon_id)** directory; relative to the addon's directory.
2. Add the image file to **styles/default/(addon_id)** directory; relative to XF's directory.
3. Create a new entry in the addon's **build.json** file, under **additional_files**.
4. Reference it in the template using: **{{ base_url('styles/default/(addon_id)/(file_name_with_extension)', true) }}**

