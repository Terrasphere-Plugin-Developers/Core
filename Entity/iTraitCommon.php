<?php


namespace Terrasphere\Core\Entity;


interface iTraitCommon
{

    //since for some reason the primary keys all have different names instead of id this gets the id
    //cant have a return type or everything explodes
    public function getID();

    //get the shortname of the eneity
    //TODO: remove the split since this is now found through filter instead of route format(: and / screwed up the route, not sure if different for filter
    public function getEntityShortName() : string;

}