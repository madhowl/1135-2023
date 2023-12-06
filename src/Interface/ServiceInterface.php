<?php

namespace App\Interface;

interface ServiceInterface
{
    /**
     * Display a listing of the resource.
     */
    public function index();

    /**
     * Show the form for creating a new resource.
     */
    public function create();

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $properties);

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(int $id);

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit(int $id);

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update();

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(int $id);


}